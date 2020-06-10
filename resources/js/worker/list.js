import { generateRoute, getRequestError } from '../helpers';
import api from '../api';
import axios from 'axios';
import VueToast from 'vue-toast-notification';
// Import any of available themes
import 'vue-toast-notification/dist/theme-default.css';
//import 'vue-toast-notification/dist/theme-sugar.css';
import VueSlider from 'vue-slider-component';
import 'vue-slider-component/theme/default.css';
import ToggleButton from 'vue-js-toggle-button';
import excel from 'vue-excel-export'; 
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css'; 
import 'vue2-datepicker/locale/es';
import VueTimepicker from 'vue2-timepicker'
import 'vue2-timepicker/dist/VueTimepicker.css'

Vue.use(VuePaginate);
Vue.use(VueToast);
Vue.forceUpdate;
Vue.use(ToggleButton);
Vue.component('VueSlider', VueSlider);
Vue.use(excel);

var VueTasks = new Vue({
  el: '#tasks',
  data: {
    tasks: window.tasks,
    task: {},
    editTask: {},
    editNotes: {},
    notes: window.notes,
    user: window.user,
    newTask: {},
    searchQuery: '',
    newNotes: [{ description: '' }],
    n: {},
    from: '',
    to: new Date(),
    sort: 'asc',
    json_fields: {
      'Fecha': 'date',
      'Tiempo total': 'worked_hours',
    },
    json_data: tasks,
    excelFilteredNotes:{},
    paginate: ['tasks'],
    showNumber:5,
    lang: {
      formatLocale: {
        firstDayOfWeek: 1,
      },
      monthBeforeYear: false,
    },
  },
  computed: {
    filteredTaskNotes() {
      return this.notes.filter((note) => {
        return note.task_id.includes(this.task.id)
      })
    },
    filteredEditTaskNotes() {
      return this.notes.filter((note) => {
        return note.task_id.includes(this.editTask.id)
      })
    },
    
  },
  methods: {
    notBeforeFrom(date) {
      return date < this.from;
    },
    notAfterTo(date) {
      return date > this.to;
    },
    onChangeDateSort() {
      switch (this.sort) {
        case 'asc':
          this.sort = 'desc'
          break
        case 'desc':
          this.sort = 'asc'
          break
      }

      api
        .post(window.getSortedTasksUrl, {
          sort: this.sort,
          userId: this.user.id,
          from: this.from,
          to: this.to,
        })
        .then(
          (response) => {
            this.tasks = response.data
          },
          (error) => {
            Vue.$toast.error(getRequestError(error))
          },
        )
    },
    filterTasks() {
      if (this.from == '' && this.to == '') {
        Vue.$toast.warning('seleccione al menos un parametro')
      } else {
        api
          .post(window.getFilteredTasksUrl, {
            from: this.from,
            to: this.to,
            userId: this.user.id,
          })
          .then(
            (response) => {
              console.log(response.data)
              if (response.data.length != 0) {
                this.tasks = response.data;
                this.json_data = this.tasks;
              } else {
                Vue.$toast.warning('No se encontraron tareas')
                this.tasks = response.data;
                this.json_data = this.tasks;
              }
            },
            (error) => {
              Vue.$toast.error(getRequestError(error))
            },
          )
      }
    },
    removeItemFromArr(arr, item) {
      var i = arr.indexOf(item)

      if (i !== -1) {
        arr.splice(i, 1)
      }
    },
    onChangeConfiguration() {
      api
        .post(
          window.updateCollectionConfigurationUrl,
          this.collectionConfiguration,
        )
        .then(
          (response) => {
            Vue.$toast.success('Configuracion de cobro guardada correctamente')
          },
          (error) => {
            Vue.$toast.error(getRequestError(error))
          },
        )
    },
    addTask() {
      if (
        !this.newTask.date ||
        !this.newTask.start ||
        !this.newTask.end ||
        !this.newNotes[0].description
      ) {
        Vue.$toast.warning('Llene todos los campos')
        return
      }

      // calculate diff hours
      var timeStart = new Date('01/01/2007 ' + this.newTask.start).getHours()
      var timeEnd = new Date('01/01/2007 ' + this.newTask.end).getHours()

      var hourDiff = timeEnd - timeStart
      this.newTask.worked_hours = hourDiff

      api
        .post(window.createTaskUrl, {
          newTask: this.newTask,
          newNotes: this.newNotes,
          userId: this.user.id,
        })
        .then(
          (response) => {
            this.tasks = [...this.tasks, response.data]

            for (let i = 0; i < this.newNotes.length; i++) {
              this.newNotes[i].task_id = response.data.id
              this.notes = [...this.notes, this.newNotes[i]]
            }

            this.newTask = {
              date: '',
              start: '',
              end: '',
              worked_hours: '',
            }
            this.newNotes = [{ description: '' }]
            Vue.$toast.success('Tarea guardada correctamente')
            this.json_data = this.tasks;
          },
          (error) => {
            Vue.$toast.error(getRequestError(error))
          },
        )
    },
    showNotesModal(task) {
      this.task = task

      $('#show-notes-task-modal').modal()
      return false
    },
    showEditTaskModal(task) {
      this.editTask = task
      this.editNotes = this.getEditTaskNotes(this.editTask)

      console.log('id en show edit ' + this.editTask.id)

      $('#edit-task-modal').modal()
      return false
    },
    getEditTaskNotes(editTask) {
      return this.notes.filter((note) => {
        return note.task_id.includes(editTask.id)
      })
    },
    showNewTaskModal() {
      $('#new-task-modal').modal()
      return false
    },
    confirmTaskDelete(task) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger',
        },
        buttonsStyling: true,
      })
      swalWithBootstrapButtons
        .fire({
          title: 'Se eliminara esta tarea',
          text: 'Esta seguro?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Si, eliminar',
          confirmButtonColor: '#28A745',
          cancelButtonText: 'No, cancelar!',
          cancelButtonColor: '#DD3A4A',
          reverseButtons: true,
        })
        .then((result) => {
          if (result.value) {
            api.post(window.deleteTaskUrl, { task: task }).then(
              (response) => {
                Vue.$toast.success('Tarea borrada correctamente')
                var i = this.tasks.indexOf(task)
                if (i !== -1) {
                  this.tasks.splice(i, 1)
                }
                this.json_data = this.tasks;
              },
              (error) => {
                Vue.$toast.error(getRequestError(error))
              },
            )
            swalWithBootstrapButtons.fire(
              'Eliminado!',
              'La tarea fue eliminado.',
              'success',
            )
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
          }
        })
    },
    updateTask() {
      console.log('id en update Task()' + this.editTask.id)
      if (
        !this.editTask.date ||
        !this.editTask.start ||
        !this.editTask.end ||
        !this.editNotes[0].description
      ) {
        Vue.$toast.warning('Llene todos los campos')
        return
      }

      // calculate diff hours
      var timeStart = new Date('01/01/2007 ' + this.editTask.start).getHours()
      var timeEnd = new Date('01/01/2007 ' + this.editTask.end).getHours()

      var hourDiff = timeEnd - timeStart
      this.editTask.worked_hours = hourDiff

      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger',
        },
        buttonsStyling: true,
      })
      swalWithBootstrapButtons
        .fire({
          title: 'Se modificara los datos de esta tarea',
          text: 'Esta seguro?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Si, modificar',
          confirmButtonColor: '#28A745',
          cancelButtonText: 'No, cancelar!',
          cancelButtonColor: '#DD3A4A',
          reverseButtons: true,
        })
        .then((result) => {
          if (result.value) {
            api
              .post(window.updateTaskUrl, {
                editTask: this.editTask,
                editNotes: this.editNotes,
                userId: this.user.id,
              })
              .then(
                (response) => {
                  console.log('responsedata: ' + response.data)
                  Vue.$toast.success('Tarea modificada correctamente')

                  var i = this.tasks.indexOf(response.data.id)
                  if (i !== -1) {
                    this.tasks[i] = response.data[0]
                  }

                  this.notes = response.data[1]

                  console.log(this.notes);

                  this.editNotes = {};
                  this.editTask = {};
                  this.json_data = this.tasks;
                },
                (error) => {
                  Vue.$toast.error(getRequestError(error))
                },
              )
            swalWithBootstrapButtons.fire(
              'Modificado!',
              'La tarea fue modificada.',
              'success',
            )
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
          }
        })
    },
    addNote: function (e) {
      e.preventDefault()
      console.log(this.newNotes.length)
      if (this.newNotes.length < 5) {
        this.newNotes.push(Vue.util.extend({}, this.newNotes))
      } else {
        Vue.$toast.warning('limite de notas alcanzado')
      }
    },
    removeNote() {
      this.newNotes.splice(-1, 1)
    },
    addEditNote: function (e) {
      e.preventDefault()
      console.log(this.editNotes.length)
      if (this.editNotes.length < 5) {
        this.editNotes.push(Vue.util.extend({}, this.editNotes))
      } else {
        Vue.$toast.warning('limite de notas alcanzado')
      }
    },
    removeEditNote() {
      this.editNotes.splice(-1, 1)
    },
  },
  components: { VueTimepicker },
});
