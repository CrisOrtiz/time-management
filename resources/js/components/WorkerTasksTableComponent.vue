<template>
  <table class="table table-responsive-md" id="example">
    <thead class="thead bg-primary" style="color:white">
      <tr>
        <th scope="col" style="width:20%">fecha</th>
        <th scope="col" style="width:20%">inicio</th>
        <th scope="col" style="width:20%">Final</th>
        <th scope="col" style="width:10%">Horas trabajadas</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="task in tasks">
        <td>{{ task.date }}</td>
        <td>{{ task.start }}</td>
        <td>{{ task.end }}</td>
        <td>{{ task.worked_hours }}</td>
      </tr>      
    </tbody>
  </table>

</template>

<script>

import datatables from 'datatables';

export default {
  mounted() {
    this.getTasks()
    console.log('Component WorkerTasks mounted.')
  },
  data(){
      return{
          tasks:[]
      };
  },
  methods:{
    mytable(){
     $(function() {
        $('#example').DataTable();
     });
    },
    getTasks(){
         var urlTasks = 'mytasks';
         axios.get(urlTasks).then(response =>{
             this.tasks = response.data;
             this.mytable()
         });
     }, 
  }
}
</script>
