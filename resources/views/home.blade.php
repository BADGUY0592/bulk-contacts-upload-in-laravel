@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (count($errors) > 0)
                        <div class = "alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ( Session::has('flash_message') )
                        <div class="alert alert-{{ Session::get('flash_type') }} alert-dismissible fade show" role="alert">
                            <b>{{ Session::get('flash_message') }}</b>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    @if(Auth::User()->isAdmin == 1)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        Add Client
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="home/client/store">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label text-md-right">Name</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control " name="name"  required  autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                                <div class="col-md-6">
                                                    <input type="email" class="form-control" name="email"  required >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label text-md-right">Password</label>
                                                <div class="col-md-6">
                                                    <input type="password" class="form-control" name="password" required >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                                <div class="col-md-6">
                                                    <input type="password" class="form-control" name="password_confirmation" required >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="role" class="col-md-4 col-form-label text-md-right">Role</label>
                                                <div class="col-md-6">
                                                    <label class="col-form-label">
                                                        <input id="role" type="checkbox" name="role"> Admin(Shows all Clients.)
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        Register
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(count($users)>0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover datatable datatable-User">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email ID</th>
                                                    <th>Contacts</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $item)
                                                    <tr>
                                                        <td>
                                                            <a href="/home/client/{{ $item->id }}/show">
                                                                {{ $item->name }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $item->email }}</td>
                                                        <td>{{ $item->contactscount }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if(method_exists($users, 'links'))
                                        {{ $users->links() }}
                                    @endif
                                @else
                                    <h6>No Clients Found.</h6>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        Add Contact
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="/home/client/contact/store" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label text-md-right">Name</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="name" autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label text-md-right">Mobile Number</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="mobile" minlength="11" maxlength="12">
                                                </div>
                                            </div>
                                            <h6 style="width: 100%;text-align: center;border-bottom: 1px solid #000;line-height: 0.1em;margin: 10px 0 20px;">
                                                <span style="background:#fff;padding:0 10px;">
                                                    OR
                                                </span>
                                            </h6>
                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label text-md-right">Select File(.xlsx)</label>
                                                <div class="col-md-8">
                                                    <input type="file" name="bulkupload" accept=" .xlsx">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(count($contacts)>0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover datatable datatable-User">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($contacts as $item)
                                                    <tr>
                                                        <td>{{ $item->name }}</td>
                                                        <td>+{{ $item->mobile }}</td>
                                                        <td>
                                                            <a href="" class="badge badge-primary editcontact" id="c{{ $item->id }}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="/home/client/contact/{{ $item->id }}/delete" class="badge badge-danger" onclick="return confirm('Do you want to delete {{ $item->name }} ?'); ">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if(method_exists($contacts, 'links'))
                                        {{ $contacts->links() }}
                                    @endif
                                @else
                                    <h6>No Contacts Found.</h6>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    <div class="modal fade" id="editcontact" tabindex="-1" role="dialog" aria-labelledby="editcontactLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editcontactLabel">Edit Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/home/client/contact/update">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Name*</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" id="cname" autofocus required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Mobile Number*</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="mobile" id="cmobile" required minlength="11" maxlength="12">
                            </div>
                        </div>
                        <input type="hidden" name="contact" id="contact" value="" required>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('JS')
<script>
    jQuery(document).ready(function ()
    {
        $('.editcontact').click(function(e){
                e.preventDefault();
                var cid=$(this).attr('id').slice(1);
                if(cid)
                {
                    jQuery.ajax({
                        url : '/api/contact/'+cid+'/get-details',
                        type : "GET",
                        dataType : "json",
                        success:function(data)
                        {
                            $('#cname').empty();
                            $('#cmobile').empty();
                            $("#cname").val(data.name);
                            $("#cmobile").val(data.mobile);
                            $("#contact").val(cid);
                            $('#editcontact').modal('show');
                        }
                    });
                }
            });
        });
    </script>
@endsection