<form method="post" action="/dentist/search">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-3">
            <input name="name" class="form-control" placeholder="Name"/>
        </div>
        <div class="col-md-3">
            <input name="city" class="form-control" placeholder="City"/>
        </div>
        <div class="col-md-2">
            <select class="form-control" name="type">
                <option value="" selected disabled>Type...</option>
                <option value="DENTIST">Dentist</option>
                <option value="ORTHODONTE">Orthodonte</option>
                <option value="SURGEON">Surgeon</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-control" name="rating" disabled>
                <option value="" selected disabled>Rating above...</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>
@if(session('search_result'))
        <hr/>
        @if(count(session('search_result')) > 0)
        <div class="row">
            <div class="col-md-10">
                <table class="table table-striped table-hover">
                    <thead class="thead-light">
                    <tr>
                        <td class="col">Name</td>
                        <td class="col">City</td>
                        <td class="col">Type</td>
                        <td class="col">Rating</td>
                        <td class="col"><span class="glyphicon glyphicon-user"></span></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(session('search_result') as $result)
                        <tr>
                            <td>{{$result->name}}</td>
                            <td>{{$result->city}}</td>
                            <td>{{$result->type}}</td>
                            <td>{{$result->reviews()->avg('rating')}}</td>
                            <td><a href="/dentist/{{$result->id}}"><span class="glyphicon glyphicon-log-in"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-warning"><p>The search returned no results.</p></div>
    @endif
@endif