<html>
  <head>
    <title>instagram API</title>
  </head>
  <body>
    <h1>instagram API</h1>
    @foreach ($mediaData as $media)
      <a href="{{$media['permalink']}}" target="_brank" rel="noopener">
        <img src="{{$media['media_url']}}" width="100px" alt="">
      </a>
    @endforeach
  </body>
</html>