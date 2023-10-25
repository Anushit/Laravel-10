<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="card w-50 ml-5">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex justify-center">
        <h3>List All Tickets </h3>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            <?php



            if (!empty($tickets)) : ?>
                @forelse ($tickets as $t)

                <tr>
                    <th scope="row">{{ $t->id }}</th>
                    <td> <a href="{{ route('ticket.show', $t->id) }}">{{ $t->title }}</td></a>
                    <td>{{ $t->description }}</td>
                    <td>
                        <div class="row flex justify-center">
                            <div class="col-md-6">
                                <a href="{{ route('ticket.edit', $t->id) }}"><button class="btn btn-info" class="ml-3">
                                        Edit
                                    </button> </a>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('ticket.destroy', $t->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger" class="ml-3">
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </div>
                        @if(auth()->user()->isAdmin)
                        <div class="row flex justify-center">
                            <div class="col-md-6">
                            <form action="{{ route('ticket.update', $t->id)}}" method="post"  >
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="status" value="approved">
                                    <button class="btn btn-primary" class="ml-3">
                                        Approved
                                    </button>
                            </form>
                            </div>
                            <div class="col-md-6">
                            <form action="{{ route('ticket.update', $t->id)}}" method="post"  >
                                @csrf
                                @method('patch')
                                <input type="hidden" name="status" value="rejected">
                                <button class="btn btn-danger" class="ml-3">
                                        Rejected
                                    </button>
                            </form>
                            </div>
                            @else
                            <p>Status: {{$t->status}}</p>
                            @endif
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="3">No Data</td>
                </tr>
                @endforelse
            <?php endif; ?>
        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>



</div>