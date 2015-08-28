(function($){
  Drupal.behaviors.nhachay = {
    attach: function(context) {
      var root_path = Drupal.settings.nhachayhomnay.root_path;
      var playing = true;
      var music_host = 'http://mp3.homnay24h.com';
      var audioId = document.getElementById('audioId');
      var currentNid = 0;

      //them data-order vao moi nut play
      $('.i-listen').each(function(i,j){
        i = i < 10 ? '0'+i:i;
        $(this).attr('data-order',i);
      });

      //Them class cho node-wrap
      $('.node-wrap').each(function(i,j){
        $(this).addClass((i + 1).toString());
      });

      /**
       * Click nut nghe nhac
       */
      $('.i-listen').click(function(){
        var me = $(this);
        var song_name = $(this).data('name'),
            provider_name = $(this).data('provider'),
            file_name = $(this).data('file'),
            singer_name = $(this).data('singer'),
            nid = $(this).data('nid'),
            n_type = $(this).data('type'),
            order = $(this).data('order');
        var url = music_host+'/'+provider_name+'/'+file_name;
        console.log(url);
        var index = $('.i-listen').index(this);
        PlayNow(nid, provider_name, file_name, song_name, singer_name, n_type, order);
      });

      function PlayNow(nid, provider_name, file_name, song_name, singer_name, n_type, order){
        var url = music_host+'/'+provider_name+'/'+file_name;
        currentNid = order;
        currentNid++;
        $('.i-large-play').removeClass('pause');
        playing = true;

        $('#sourceId').attr('src',url);
        $('#play-section').show();
        $('#footer').css('margin-bottom','92px');
        $('.music-name').html(song_name);
        $('.singer-name').html(singer_name);
        $(audioId).trigger('load');
        $(audioId).trigger('play');

        $('.remain-time').html('00:00');
        $('.total-time').html('00:00');

        checkEnded();
        if(n_type == 'nhac_so'){
          //Tang luot nghe len cho node
          $.ajax({
            type: 'POST',
            url: root_path+'api/listen',
            data: { 'from_js': true, 'node_id': nid},
            dataType: "json",
            success: function (data) {
              //if (data.message != null) {
              if (data.message) {
                console.log(data.message);
              }
              //}
            },
            error: function (xmlhttp) {
              // Error alert for failure
              alert('An error occurred: ' + xmlhttp.status);
            }
          });
        }
      }

      function next(){
        currentNid++;
        console.log('next currentId:' + currentNid);
        var length_node_wrap = $('.node-wrap').length;
        console.log('length_node_wrap:' + length_node_wrap);
        if(currentNid <= length_node_wrap){
          var next_node = $('.node-wrap.'+ currentNid +' .i-listen'),
              song_name = next_node.data('name'),
              provider_name = next_node.data('provider'),
              file_name = next_node.data('file'),
              singer_name = next_node.data('singer'),
              nid = next_node.data('nid'),
              n_type = next_node.data('type'),
              order = next_node.data('order');
          PlayNow(nid, provider_name, file_name, song_name, singer_name, n_type,order);
        }
      }

      $('.i-large-play').click(function(){
        var audioId = $('#audioId');
        if (playing) {
          $(this).addClass('pause');
          playing = false;
          audioId.trigger('pause');
        } else {
          $(this).removeClass('pause');
          playing = true;
          audioId.trigger('play');
          checkEnded();
        }
      });

      //Play progress ###############################//
      $(audioId).bind('timeupdate',function(){
        var timePercent = (this.currentTime / this.duration) * 100;
        $('#play_progress').css({width: timePercent + "%"});
        UpdateTheTime();
      });

      //Load progress ###############################//
      $(audioId).bind('progress',function(){
        updateLoadProgress();
      });
      $(audioId).bind('loadeddata',function(){
        updateLoadProgress();
      });
      $(audioId).bind('canplaythrough',function(){
        updateLoadProgress();
      });
      $(audioId).bind('playing',function(){
        updateLoadProgress();
      });
      $(audioId).bind('durationchange',function(){
        //console.log('fuck change');
      });

      //Click progress bar to seek music
      $('#progress').bind('click',function(e){
        var parentOffset = $(this).offset();
        //or $(this).offset(); if you really just want the current element's offset
        var relX = e.pageX - parentOffset.left;
        var relY = e.pageY - parentOffset.top;
        var myWith = $(this).width();
        var withPercewnt = (relX / myWith) * 100;
        var seekTime = (withPercewnt * audioId.duration) / 100;
        audioId.currentTime = seekTime;
        if(audioId.paused){
          $('.i-large-play').removeClass('pause');
          $(audioId).trigger('play');
        }
      });

      function doSomething(e) {
        var posx = 0;
        var posy = 0;
        if (!e) var e = window.event;
        if (e.pageX || e.pageY) 	{
          posx = e.pageX;
          posy = e.pageY;
        }
        else if (e.clientX || e.clientY) 	{
          posx = e.clientX + document.body.scrollLeft
          + document.documentElement.scrollLeft;
          posy = e.clientY + document.body.scrollTop
          + document.documentElement.scrollTop;
        }
        // posx and posy contain the mouse position relative to the document
        // Do something with this information
      }

      function updateLoadProgress(){
        if(audioId.buffered.length > 0) {
          var percent = (audioId.buffered.end(0) / audioId.duration) * 100;
          $('#load_progress').css({width: percent + "%"});
        }
      }

      function displayTimeMusic(time){
        var sec = time;
        var h = Math.floor(sec / 3600);
        sec = sec % 3600;
        var min = Math.floor(sec / 60);
        sec = Math.floor(sec % 60);
        if (sec.toString().length < 2) sec = "0" + sec;
        if (min.toString().length < 2) min = "0" + min;
        return  min+':'+sec;
      }

      //executes when audio plays and the time is updated in the audio element, this writes the current duration elapsed in the label element
      function UpdateTheTime() {
        $('.remain-time').html(displayTimeMusic(audioId.currentTime));
        $('.total-time').html(displayTimeMusic(audioId.duration));
        //seekbar.min = audio.startTime;
        //seekbar.max = audio.duration;
        //seekbar.value = audio.currentTime;
      }


      function checkEnded() {
        var aid = document.getElementById("audioId");
        var t = setInterval(function () {
          //console.log(aid.ended);
          if (aid.ended) {
            $('.i-large-play').addClass('pause');
            playing = false;
            next();
            clearInterval(t);
          }
        }, 1000);
      }

      /*Search*/
      $('#btn-search').click(function(e){
        e.preventDefault();
        var key_word = $('input[name="search"]').val();
        if(key_word != ''){
          enter_search();
        } else {
          console.log('key_word');
        }
      });
      $('input[name="search"]').keypress(function(e){
        if(e.which == 13){
          console.log('go enter');
          enter_search();
        }
      });

      //Search ten ca si #####################################
      $('.t-singer').click(function(e){
          var name_search = $(this).html();
          if(name_search.trim() != "") window.location.assign(window.location.origin +"/search/node/"+(name_search));
        }
      );

      function enter_search(){
        var key_word = $('input[name="search"]').val();
        if(key_word.trim() != "") window.location.assign(window.location.origin +"/search/node/"+(key_word));
      }
      /*Tai nhac so ve may*/
      $('.dl_nhac_so').click(function(e){
        var file_name = $(this).data('file');
        var url = music_host+'/nhacso/'+file_name;
        if(file_name != ''){
          file_name = url.substring(url.lastIndexOf("/") + 1).split("?")[0];
          //window.location = url;
          //saveFile(url);
          SaveToDisk(url,file_name);
        } else {
          alert('File not found');
        }
      });

      /*function SaveToDisk(fileURL, fileName) {
        // for non-IE
        if (!window.ActiveXObject) {
          var save = document.createElement('a');
          save.href = fileURL;
          save.target = '_blank';
          save.download = fileName || fileURL;
          var evt = document.createEvent('MouseEvents');
          evt.initMouseEvent('click', true, true, window, 1, 0, 0, 0, 0,
              false, false, false, false, 0, null);
          save.dispatchEvent(evt);
          (window.URL || window.webkitURL).revokeObjectURL(save.href);
        }

        // for IE
        else if ( !! window.ActiveXObject && document.execCommand)     {
          var _window = window.open(fileURL, "_blank");
          _window.document.close();
          _window.document.execCommand('SaveAs', true, fileName || fileURL);
          _window.close();
        }
      }*/

      /*function SaveToDisk(fileURL, fileName) {
        // for non-IE
        if (!window.ActiveXObject) {
          var save = document.createElement('a');
          save.href = fileURL;
          save.target = '_blank';
          save.download = fileName || 'unknown';

          var event = document.createEvent('Event');
          event.initEvent('click', true, true);
          save.dispatchEvent(event);
          (window.URL || window.webkitURL).revokeObjectURL(save.href);
        }

        // for IE
        else if ( !! window.ActiveXObject && document.execCommand)     {
          var _window = window.open(fileURL, '_blank');
          _window.document.close();
          _window.document.execCommand('SaveAs', true, fileName || fileURL);
          _window.close();
        }
      }*/

      /*function SaveToDisk(blobURL, fileName) {
        var reader = new FileReader();
        reader.readAsDataURL(blobURL);
        reader.onload = function (event) {
          var save = document.createElement('a');
          save.href = event.target.result;
          save.target = '_blank';
          save.download = fileName || 'unknown file';

          var event = document.createEvent('Event');
          event.initEvent('click', true, true);
          save.dispatchEvent(event);
          (window.URL || window.webkitURL).revokeObjectURL(save.href);
        };
      }*/

      function SaveToDisk(fileUrl, fileName) {
        var hyperlink = document.createElement('a');
        hyperlink.href = fileUrl;
        hyperlink.target = '_blank';
        hyperlink.download = fileName || fileUrl;

        var mouseEvent = new MouseEvent('click', {
          view: window,
          bubbles: true,
          cancelable: true
        });

        hyperlink.dispatchEvent(mouseEvent);
        (window.URL || window.webkitURL).revokeObjectURL(hyperlink.href);
      }

      // Download a file form a url.
      function saveFile(url) {
        // Get file name from url.
        var filename = url.substring(url.lastIndexOf("/") + 1).split("?")[0];
        var xhr = new XMLHttpRequest();
        xhr.responseType = 'blob';
        xhr.onload = function() {
          var a = document.createElement('a');
          a.href = window.URL.createObjectURL(xhr.response); // xhr.response is a blob
          a.download = filename; // Set the file name.
          a.style.display = 'none';
          document.body.appendChild(a);
          a.click();
          delete a;
        };
        xhr.open('GET', url);
        xhr.send();
      }

      /*Tai nhac cho*/
      $('.dl_nhac_cho').click(function(e){
        var number = $(this).data("number");
        var code = $(this).data("code");
        var syntax = code.split(' ');
        var name = $(this).data("name");
        console.log(number+code+name);
        $('body').append('<div id="popUpTip" class="popup_tip"> ' +
          '<div class="tip"> ' +
            '<p>Để cài đặt bài hát yêu thích</p> ' +
            '<p><strong>'+name+'</strong></p> ' +
            '<p class="cu_phap"> SOẠN: <span>' + syntax[0] + ' ' + syntax[1] +'</span> GỬI <span>' + number + '</span> </p> ' +
          '</div> ' +
          '<div class="tip_submit"> <a class="send" href="sms:' + number + '?body=' + syntax[0] + ' ' + syntax[1] +'">Gửi</a> <a class="cancel" href="#">Hủy</a> </div> ' +
        '</div>');
        pop_up_tip();
      });

      function pop_up_tip(){
        var popUpTip = $('#popUpTip');
        $(popUpTip).fadeIn(300);

        var popMargTop = ($(popUpTip).height() + 24) / 2;
        var popMargLeft = ($(popUpTip).width() + 24) / 2;

        $(popUpTip).css({
          'margin-top' : -popMargTop,
          'margin-left' : -popMargLeft
        });

        $('body').append('<div id="mask"></div>');
        $('#mask').fadeIn(300);

        // When clicking on the button close or the mask layer the popup closed
        $('.cancel, #mask').click(function(e) {
          e.preventDefault();
          $('#mask, .popup_tip').fadeOut(300 , function() {
            $('#mask').remove();
            $('.popup_tip').remove();
          });
          return false;
        });
      }
    }
  }
})(jQuery);