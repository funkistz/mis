<div class="col-md-{{ $col or '6' }}">
  <div class="panel panel-default">
    <div class="panel-heading">News</div>
    <div class="panel-body">
      @php
        $news = App\Models\News::where('is_active', 1)->with('user')->get();
      @endphp

      <div class="media">
        @foreach($news as $news)
        <div class="media-left media-middle">
          <a href="#">
            @if (($news->user->profile) && $news->user->profile->avatar_status == 1)
                <img src="{{ $news->user->profile->avatar }}" alt="{{ $news->user->name }}" class="user-avatar-nav">
            @else
                <div class="user-avatar-nav"></div>
            @endif
          </a>
        </div>
        <div class="media-body">
          <h4 class="media-heading">{{ $news->title }}
            @role(['staff'])
            @if( auth()->user()->id == $news->created_by )
            <span class="text-right">
              {!! Form::open(array('route' => ['news.destroy', $news->id], 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                  {!! Form::hidden('_method', 'DELETE') !!}
                  {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Delete</span>', array('class' => 'btn btn-danger btn-xs pull-right','type' => 'button' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete', 'data-message' => 'Are you sure you want to delete this News ?')) !!}
              {!! Form::close() !!}
            </span>
            @endif
            @endrole
          </h4>
          <small>by {{ $news->user->name }}</small><br>
          {{ $news->description }}
        </div>
        <br>
        @endforeach
      </div>

      @if(!empty($add_news))
      <hr>

      {!! Form::open(['route' => 'news.store', 'class' => 'form', 'role' => 'form', 'method' => 'POST'] ) !!}

          {{ csrf_field() }}

          <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
              <input type="text" class="form-control" name="title" placeholder="Title" required/>
          </div>

          <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
              <textarea class="form-control" name="description" placeholder="Description" required></textarea>
          </div>

          <div class="text-right">
              <button type="submit" class="btn btn-primary">
                  Add News
              </button>
          </div>

      {!! Form::close() !!}
      @endif
    </div>
  </div>
</div>

@include('modals.modal-delete')
