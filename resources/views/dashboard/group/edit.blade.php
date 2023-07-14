@include("dashboard.include.header")
<div class="page has-sidebar-left height-full">
<div class="container-fluid relative animatedParent animateOnce">
    <div class="animated fadeInUpShort">
        <div class="row my-3">
            <div class="col-md-12">
                <form action="{!! route('dash.atualiza', $group->id) !!}" method="POST">
                    <div class="card no-b  no-r">
                        <div class="card-body">
                            <h5 class="card-title">Grupo {!! $group->name !!}  </h5>
                            <hr>

                            <style>

                                .form-control { padding:20px !important; }
                                .form-group { margin-top:20px !important; }
                                .s-28 { font-size:27px !important; position: relative; top:5px; }
                            </style>
                           @csrf
                            <div class="form-row mt-1">
                                <div class="form-group col-12 m-0">
                                    <label for="nome" class="col-form-label s-12"><i class="icon-credit-card-2 s-28 mr-2"></i>Nome do grupo </label>
                                    <input id="nome" name="name" placeholder="Digite aqui" value="{!! $group->name !!}" class="@error('name') border-danger @enderror form-control r-0 light s-12 " type="text">
                                </div>
                                <div class="form-group col-12 m-0">
                                    {!!Form::label('users[]', 'Usuários')!!}
                                    {!!Form::select('users[]', $users, $user, ['class' => 'js-example-basic-multiple',  'required', 'multiple' => 'multiple'])!!}

                                   <div style="position:relative; top:5px;" id="resultCpf"></div>
                                </div>

                                <div class="form-group col-12 m-0">
                                    <div class="card card-permissions my-2">
                                       <div class="card-header bg-primary text-white">
                                        <i class="icon-settings2"></i> Permissões de Rotas do sistema
                                       </div>
                                       <div class="card-body">
                                               @php
                                               $group  = null;
                                               $rowkey = 0;
                                               @endphp

                                               @foreach ($permissions->all() as $key => $value)

                                                 @if ($value->groupname != $group)
                                                    @php
                                                        $group = null;
                                                    @endphp

                                                    @if ($rowkey != 0)
                                                         </div>
                                                    </fieldset>
                                                     @endif
                                                 @endif

                                                 @if (is_null($group))
                                                     @php
                                                         $group = $value->groupname;
                                                     @endphp

                                                     <fieldset class="mb-3">
                                                          <legend style="font-size:20px !important" class="text-primary">{!!$group!!}</legend>
                                                          <hr>
                                                           <div class="row">
                                                 @endif

                                                 <style>

                                                .custom-control-label::after, .custom-control-label::before {top:0px !important; }

                                                    </style>

                                                 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                     <div class="custom-control custom-checkbox">
                                                        {!!Form::checkbox('permissions[]', $value->id, isset($role) ? in_array($value->id, $role) : false, [ "id" => "permissions-".$value->id, "class" => "custom-control-input form-check-input"])!!}
                                                         {!!Form::label("permissions-".$value->id, $value->nickname, ["class" => "custom-control-label"])!!}
                                                     </div>
                                                 </div>

                                                   @php
                                                       $rowkey ++;
                                                   @endphp
                                             @endforeach
                                        </div>
                                </div>
                            </div>



                            </div>
                        </div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="icon-save mr-2"></i>Salvar</button>
                        </div>
                    </form>
                    </div>
                @include('alert')
            </div>
        </div>
</div>
</div>
</div>
</div>
<!-- Right Sidebar -->
<script src="{!! asset('assets/js/app.js') !!}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
</body>
</html>
