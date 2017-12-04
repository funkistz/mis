<div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-heading">Timeline</div>
    <div class="panel-body">
      <table class="table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Task</th>
          </tr>
        </thead>
        <tbody>
          @foreach(auth()->user()->logs as $log)
          <tr>
            <td>{{$log->created_at}}</td>
            <td>{{$log->log}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
