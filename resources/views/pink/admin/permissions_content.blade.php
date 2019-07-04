<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body  ">
                <h5 class="card-title m-b-0 float-left ">Set Privileges</h5>
            </div>

            <form action="{{ route('permissions.store') }}" method="post">
                <table class="table">
                    <thead>
                    <tr class="bg-light">
                        <th scope="col">Permissions</th>
                        @if(!$roles->isEmpty())
                            @foreach($roles as $role_item)
                                <th scope="col">{{ $role_item->name }}</th>
                            @endforeach

                        @endif
                    </tr>
                    </thead>
                    <tbody>

                        @if(!$permissions->isEmpty())

                            @foreach($permissions as $permission_item)

                                <tr>
                                    <td>{{ $permission_item->name }}</td>

                                    @foreach($roles as $role)
                                        <td>
                                            <div class="custom-control custom-checkbox mr-sm-2">
                                                <input type="checkbox"
                                                       {{ $role->hasPermissions($permission_item->name) ? 'checked' : '' }}
                                                       name="{{ $role->id }}[]"
                                                       value="{{ $permission_item->id }}"
                                                       class="custom-control-input"
                                                       id="customControlAutosizing{{$permission_item->id.$role->id}}">
                                                <label class="custom-control-label" for="customControlAutosizing{{$permission_item->id.$role->id}}"></label>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                        @endif

                    </tbody>
                </table>

                <div class="border-top">
                    <div class="card-body">
                        <input type="submit" value="Save" class="btn btn-primary">
                    </div>
                </div>

                {{ csrf_field() }}
            </form>






        </div>
    </div>
</div>






