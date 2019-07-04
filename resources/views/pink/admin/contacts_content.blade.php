@if($contacts && count($contacts) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body  ">
                    <h5 class="card-title m-b-0 float-left ">Contacts</h5>
                    <a href="{{ route('contact.create') }}" class="btn btn-success  float-right"><i class="mdi mdi-plus"></i>Add</a>
                </div>

                <table class="table">
                    <thead>
                    <tr class="bg-light">
                        <th scope="col">#</th>
                        <th scope="col">icon</th>
                        <th scope="col">Name</th>
                        <th scope="col">Value</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <th scope="row">{{ $contact->id }}</th>
                            <td><i class="{{ $contact->icon }}"></i></td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->value }}</td>

                            <td>
                                <a href="{{ route('contact.edit', ['contact'=>$contact->id]) }}" class="btn btn-cyan btn-sm m-1 btn-block">Edit</a>

                                <form action="{{ route('contact.destroy', ['contact'=>$contact->id]) }}" method="post">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <input type="submit" name="delete" value="Delete" class="btn btn-danger btn-sm m-1 btn-block">
                                </form>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <p>{{ Lang::get('ru.no_contacts') }}</p>
@endif





