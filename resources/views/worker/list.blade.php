@extends('layouts.worker-page')

@section('styles')

@stop

@section('scripts')
<script>
    window.domainUrl = "{!! Request::url() !!}";
    window.createTaskUrl = "{!! route('task.create') !!}";
    window.updateTaskUrl = "{!! route('task.update') !!}";
    window.deleteTaskUrl = "{!! route('task.delete') !!}";
    window.getTasksUrl = "{!! route('tasks.get') !!}";
    window.getFilteredTasksUrl = "{!! route('tasks.filtered.get') !!}";
    window.getSortedTasksUrl = "{!! route('tasks.sorted.get') !!}";
    window.tasks = @json($tasks);
    window.user = @json($user);
    window.notes = @json($notes);
</script>
<script src="{{ mix('js/plugins/bootstrap-slider.min.js') }}"></script>
<script src="{{ mix('js/plugins/switchery.min.js') }}"></script>
<script src="{{ mix('js/plugins/bootstrap-input-spinner.js')}}"></script>
<script src="{{ mix('js/plugins/spectrum.min.js')}}"></script>
<script src="{{ mix('js/worker/list.js') }}"></script>


@stop

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12">
            @if(auth()->user()->user_type == 3)
            <h1 class="m-0 text-dark">Mis Tareas</h1>
            @else
            <h1 class="m-0 text-dark">Tareas de usuario</h1>
            @endif
        </div>

    </div>
    @if(Session::has("success"))
    <div class="col-12">
        <div class="alert alert-success alert-dismissible mb-0 mt-3">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <div>{{ Session::get("success") }}</div>
        </div>
    </div>
    @endif
</div>
@stop

@section('content')
<div class="container-fluid" id="tasks">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="float:left" class="mb-4">
                            <label for="from">De:</label>
                            <date-picker type="date" valueType="YYYY-MM-DD" v-model="from" :lang="lang" format="YYYY-MM-DD" :disabled-date="notAfterTo"></date-picker>                            
                        </div>
                        <div style="float:left" class="mb-4 ml-2">
                            <label for="to" >Hasta:</label>
                            <date-picker type="date" valueType="YYYY-MM-DD" v-model="to" :lang="lang" format="YYYY-MM-DD" :disabled-date="notBeforeFrom"></date-picker>   
                            <button class="btn btn-sm btn-primary ml-2 mb-1" v-on:click="filterTasks()"><i class="fa fa-search"></i></button>
                        </div>


                        <div style="float:right" class="mb-4">
                            <button class="btn btn-success btn-md mr-2" type="button" v-on:click="showNewTaskModal()">Nueva Tarea<i class="fa fa-plus ml-2"></i></button>
                        </div>

                        <div style="float:right" class="mb-4">
                            <export-excel class="btn btn-default mr-3" :data="json_data" :fields="json_fields" worksheet="Tareas" name="tareas.xls" title="TAREAS">
                                Descargar excel
                                <i class="fa fa-download ml-2"></i>
                            </export-excel>
                        </div>
                        <table class="table table-md table-stripped table-bordered" id="tasks-table" style="text-align:center;">
                            <thead style="color:white; background-color:#007BFF">
                                <tr>
                                    <th scope="col" style="width:20%">Fecha <i v-on:click="onChangeDateSort()" style="color:white" v-bind:class="{'fa fa-sort-up ml-2': sort=='asc',  'fa fa-sort-down ml-2': sort=='desc'}" aria-hidden="true"></i></th>
                                    <th scope="col" style="width:20%">Inicio</th>
                                    <th scope="col" style="width:20%">Final</th>
                                    <th scope="col" style="width:20%">Horas trabajadas</th>
                                    <th scope="col" style="width:20%">Notas </th>
                                    <th scope="col" colspan="2" style="width:20%">Opciones</th>
                                </tr>
                            </thead>
                            <tbody style="font-weight:bold;margin: 0 auto;font-size:115%;color:gray;">
                                <paginate name="tasks" :list="tasks" :per="showNumber">
                                    <tr v-for="task in  paginated('tasks')">
                                        <td v-bind:style="[task.worked_hours < user.preferred_working_hours_per_day ? {'border-top': '3px solid #F47378','border-bottom': '3px solid #F47378','border-left': '3px solid #F47378'} : {'border-top': '4px solid #6BD089','border-bottom': '3px solid #6BD089','border-left': '3px solid #6BD089'}]">@{{ task.date }}</td>
                                        <td v-bind:style="[task.worked_hours < user.preferred_working_hours_per_day ? {'border-top': '3px solid #F47378','border-bottom': '3px solid #F47378'} : {'border-top': '4px solid #6BD089','border-bottom': '3px solid #6BD089'}]">@{{ task.start }}</td>
                                        <td v-bind:style="[task.worked_hours < user.preferred_working_hours_per_day ? {'border-top': '3px solid #F47378','border-bottom': '3px solid #F47378'} : {'border-top': '4px solid #6BD089','border-bottom': '3px solid #6BD089'}]">@{{ task.end }}</td>
                                        <td v-bind:style="[task.worked_hours < user.preferred_working_hours_per_day ? {'border-top': '3px solid #F47378','border-bottom': '3px solid #F47378','border-right': '3px solid #F47378'} : {'border-top': '4px solid #6BD089','border-bottom': '3px solid #6BD089','border-right': '3px solid #6BD089'}]">@{{ task.worked_hours }}</td>
                                        <td>
                                            <button class="btn btn-secondary btn-notes btn-md" type="button" v-on:click="showNotesModal(task);">Ver notas<i class="fas fa-clipboard ml-2"></i></button>
                                        </td>
                                        <td class="d-flex justify-content-sm-between" colspan="3">
                                            <button class="btn btn-primary btn-edit btn-md m-1" type="button" v-on:click="showEditTaskModal(task);"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger btn-delete btn-md m-1" type="button" v-on:click="confirmTaskDelete(task);"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </paginate>

                            </tbody>
                            <tfoot>
                                <tr>
                                </tr>
                            </tfoot>
                        </table>
                        <div style="float:left" class="ml-2">
                        <label >Mostrar:</label>
                            <select v-model="showNumber">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="30">30</option>
                            </select>
                        </div>
                        <div style="float:right">
                            <paginate-links for="tasks" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}" :show-step-links="true" :step-links="{next: '>',prev: '<'}"></paginate-links>
                        </div>
                    </div>
                </div><!-- /.card-body -->
            </div>
        </div>
    </div>




    <!-- Modal show notes Task-->
    <div class="modal fade" id="show-notes-task-modal" tabindex="-1" role="dialog" aria-labelledby="show-notes-task-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Notas de la tarea</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="modal-data-container">
                        <table class="table table-md table-striped table-bordered" id="tasks-table" style="text-align:center;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width:80%">Día: @{{ task.date }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="note in filteredTaskNotes">
                                    <td>@{{ note.description }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Task-->
    <div class="modal fade" id="edit-task-modal" tabindex="-1" role="dialog" aria-labelledby="edit-task-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Tarea</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="modal-data-container">
                        <div class="info-row">
                            <div style="width:100%;margin-left:22.5%" class="form">
                                <section class="Form__section">
                                    <div class="form-group">
                                        <label for="date">Fecha:</label>
                                        <input type="date" class="form-control" name="date" v-model="editTask.date" value="{{ old('date') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="start">Inicio:</label>
                                        <input type="time" class="form-control" name="start" v-model="editTask.start" value="{{ old('start') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="end">Final:</label>
                                        <input type="time" class="form-control" name="end" v-model="editTask.end" value="{{ old('end') }}">
                                    </div>
                                </section>
                                <section class="Form__section">
                                    <label for="notes">Notas (max. 5):</label> <i class="fas fa-plus-circle" style="color:green" @click="addEditNote"></i>
                                    <i class="fas fa-minus-circle" style="color:red" @click="removeEditNote()" v-show="( editNotes.length > 1)"></i>
                                    <div class="Form__section" v-for="n in editNotes">
                                        <div class="form-group">
                                            <input type="text" name="note" id="" class="form-control" placeholder="Nota" v-model="n.description" value="{{ old('note') }}">
                                        </div>
                                    </div>
                                </section>
                                <div class="form-group" id="notes">
                                    <button class="btn btn-success mt-4" @click="updateTask()" data-dismiss="modal">Modificar tarea</button>
                                </div>
                            </div>
                            <span class="loan-modal-data"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal New Task-->
    <div class="modal fade" id="new-task-modal" tabindex="-1" role="dialog" aria-labelledby="new-task-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nueva Tarea</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="modal-data-container">
                        <div class="info-row">
                            <div style="width:100%;margin-left:22.5%" class="form">
                                <section class="Form__section">
                                    <div class="form-group">
                                        <label for="date">Fecha:</label>
                                        <input type="date" class="form-control" name="date" v-model="newTask.date" value="{{ old('date') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="start">Inicio:</label>
                                        <input type="time" class="form-control" name="start" v-model="newTask.start" value="{{ old('start') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="end">Final:</label>
                                        <input type="time" class="form-control" name="end" v-model="newTask.end" value="{{ old('end') }}">
                                    </div>
                                </section>
                                <section class="Form__section">
                                    <label for="notes">Notas (max. 5):</label> <i class="fas fa-plus-circle" style="color:green" @click="addNote"></i>
                                    <i class="fas fa-minus-circle" style="color:red" @click="removeNote()" v-show="( newNotes.length > 1)"></i>
                                    <div class="Form__section" v-for="n in newNotes">
                                        <div class="form-group">
                                            <input type="text" name="note" id="" class="form-control" placeholder="Nota" v-model="n.description" value="{{ old('note') }}">
                                        </div>
                                    </div>
                                </section>
                                <div class="form-group" id="notes">
                                    <button class="btn btn-success mt-4" @click="addTask()" data-dismiss="modal">Añadir tarea</button>
                                </div>
                            </div>

                            <span class="loan-modal-data"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop