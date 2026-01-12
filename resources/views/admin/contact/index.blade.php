@extends('adminlayouts.app')
@section('content')

<div class="content-wrapper">
    <div class="row">  
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            
            </p>
            <div class="table-responsive">
              <table class="table table-striped">
                  <thead>
                         <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Message</th>
                        </tr>
                      </thead>
                       <tbody>
                  @if($contact->isNotEmpty())
                      @foreach($contact as $contacts)
                        <tr class="align-middle">
                          <td>{{$contacts->id}}</td>
                          <td>{{$contacts->name}}</td>
                          <td>{{$contacts->phone}}</td>
                          <td>{{$contacts->email}}</td>
                          <td>{{$contacts->subject}}</td>
                
                          <td>
                            <span 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="{{ $contacts->message }}"
                                style="cursor: pointer;"
                            >
                                {{ \Illuminate\Support\Str::limit($contacts->message, 20) }}
                            </span>
                        </td>

                       
                        </tr>
                        @endforeach
                        @endif
                </tbody>
              </table>
            </div>
            <div class="card-footer clearfix">
            <div class="d-flex justify-content-end">
               {{ $contact->links('pagination::bootstrap-5') }}
            </div>
        </div>

          </div>
        </div>
      </div>
    </div>
</div>



@endsection
