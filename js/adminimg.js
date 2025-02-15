function handleFileSelect(evt) {
    var files = evt.target.files;
    for (var i = 0, f; f = files[i]; i++) {
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();
      reader.onload = (function(theFile) {
        return function(e) {
          var span = document.getElementById('span');
          span.innerHTML = ['<img class="album" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
        };
      })(f);

      reader.readAsDataURL(f);
    }
  }

  document.getElementById('files').addEventListener('change', handleFileSelect, false);