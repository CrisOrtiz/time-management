import { generateRoute, getRequestError } from '../helpers'
import api from '../api'
import axios from 'axios'
import VueToast from 'vue-toast-notification'
// Import any of available themes
import 'vue-toast-notification/dist/theme-default.css'
//import 'vue-toast-notification/dist/theme-sugar.css';
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'
import ToggleButton from 'vue-js-toggle-button'

Vue.use(VuePaginate);
Vue.use(VueToast)
Vue.forceUpdate
Vue.use(ToggleButton)
Vue.component('VueSlider', VueSlider)

var vueUsers = new Vue({
  el: '#users',
  data: {
    users: window.users,
    newUser: {},
    editUser: { password: '' },
    changePassword: false,
    user: window.user,
    sort: 'asc',
    paginate: ['users'],
    showNumber:5
  },
  computed: {},
  methods: {
    onChangeNameSort() {
      switch (this.sort) {
        case 'asc':
          this.sort = 'desc'
          break
        case 'desc':
          this.sort = 'asc'
          break
      }

      api
        .post(window.getSortedUsersUrl, {
          sort: this.sort,
        })
        .then(
          (response) => {
            this.users = response.data
          },
          (error) => {
            Vue.$toast.error(getRequestError(error))
          },
        )
    },
    showEditUserModal(user) {
      this.editUser = user

      console.log('id en show edit ' + this.editUser.id)

      $('#edit-user-modal').modal()
      return false
    },
    showNewUserModal() {
      $('#new-user-modal').modal()
      return false
    },
    registerUser() {
      if (
        !this.newUser.name ||
        !this.newUser.surname ||
        !this.newUser.username ||
        !this.newUser.password ||
        !this.newUser.password_confirm ||
        !this.newUser.user_type
      ) {
        Vue.$toast.warning('Llene todos los campos')
        return
      }
      if (
        this.newUser.password == this.newUser.password_confirm &&
        this.newUser.password.length >= 6
      ) {
        api
          .post(window.registerUserUrl, {
            newUser: this.newUser,
          })
          .then(
            (response) => {
              this.users = [...this.users, response.data]

              this.newUser = {}

              Vue.$toast.success('Usuario registrado correctamente')
            },
            (error) => {
              Vue.$toast.error(getRequestError(error))
            },
          )
      } else {
        Vue.$toast.warning('Verifique las contraseñas')
      }
    },
    confirmUserDelete(user) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger',
        },
        buttonsStyling: true,
      })
      swalWithBootstrapButtons
        .fire({
          title: 'Se eliminara este usuario',
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
            api.post(window.deleteUserUrl, { user }).then(
              (response) => {
                Vue.$toast.success('Usuario borrado correctamente')
                var i = this.users.indexOf(user)
                if (i !== -1) {
                  this.users.splice(i, 1)
                }
              },
              (error) => {
                Vue.$toast.error(getRequestError(error))
              },
            )
            swalWithBootstrapButtons.fire(
              'Eliminado!',
              'El usuario fue eliminado.',
              'success',
            )
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
          }
        })
    },
    updateUser() {
      console.log('id en update user()' + this.editUser.id)
      console.log('password en update user()' + this.editUser.password)
      if (
        !this.editUser.name ||
        !this.editUser.surname ||
        !this.editUser.username ||
        !this.editUser.user_type
      ) {
        Vue.$toast.warning('Llene todos los campos')
        return
      }

      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger',
        },
        buttonsStyling: true,
      })
      swalWithBootstrapButtons
        .fire({
          title: 'Se modificara los datos de este usuario',
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
            if (this.changePassword == false) {
              this.editUser.password = ''
              api.post(window.updateUserUrl, { editUser: this.editUser }).then(
                (response) => {
                  console.log('responsedata: ' + response.data)
                  Vue.$toast.success('Usuario modificado correctamente')

                  var i = this.users.indexOf(response.data.id)
                  if (i !== -1) {
                    this.users[i] = response.data
                  }
                },
                (error) => {
                  Vue.$toast.error(getRequestError(error))
                },
              )
            } else {
              if (this.editUser.password == this.editUser.password_confirm) {
                if (this.editUser.password.length >= 6) {
                  api
                    .post(window.updateUserUrl, { editUser: this.editUser })
                    .then(
                      (response) => {
                        console.log('responsedata: ' + response.data)
                        Vue.$toast.success('Usuario modificado correctamente')

                        var i = this.users.indexOf(response.data.id)
                        if (i !== -1) {
                          this.users[i] = response.data
                        }
                      },
                      (error) => {
                        Vue.$toast.error(getRequestError(error))
                      },
                    )
                } else {
                  Vue.$toast.warning('Verifique la contraseña')
                }
              } else {
                Vue.$toast.warning('Verifique la contraseña')
              }
            }
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
          }
        })
    },
  },
})
