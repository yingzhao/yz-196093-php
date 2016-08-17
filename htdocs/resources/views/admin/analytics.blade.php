@extends('admin')

@section('content')
  <h3>Analytics</h3>

  <div class="row">
    <div class="col-md-12">
      <p>Graphs displaying dummy content currently. Stats will be computed from the database and will go here as well as the graphs.</p>
      <hr>

      <div class="row">
        <div class="col-md-4">
          <h4>Clicks &lt;30 days</h4>
          <h3>33</h3>
        </div>
        <div class="col-md-4">
          <h4>Clicks all time</h4>
          <h3>3,242</h3>
        </div>
        <div class="col-md-4">
          <h4>Most popular network</h4>
          <h3>Twitter</h3>
        </div>
      </div>
      <hr>

       <div class="row">
        <div class="col-md-4">
          <h4>Views &lt;30 days</h4>
          <h3>6300</h3>
        </div>
        <div class="col-md-4">
          <h4>Views all time</h4>
          <h3>124,342,342</h3>
        </div>
        <div class="col-md-4">
          <h4>Retweets</h4>
          <h3>22</h3>
        </div>
      </div>
      <hr>
  
      <div class="row">
        <div class="col-md-12">
          <h4 class="graph-title">No of clicks</h4>
          <div id="clicks_months"></div>
          @linechart('clicks_months', 'clicks_months')
          <hr>

          <h4 class="graph-title">Page views over time</h4>
          <div id="page_views"></div>
          @linechart('clicks_months', 'page_views')
        </div>
      </div>

    </div>
  </div>
@endsection
