<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/barcode.jpg" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-data">
          <table class="form">
            <tr>
              <td><?php echo $entry_scanner; ?></td>
              <td id="container" class="container" style="max-width: 1027px;">
                <div class="controls">
                  <button class="stop">Stop</button>
                  <fieldset class="reader-group">
                      <label>EAN</label>
                      <input type="radio" name="reader" value="ean" checked="checked" />
                      <label>Code128</label>
                      <input type="radio" name="reader" value="code_128" />
                      <label>Code39</label>
                      <input type="radio" name="reader" value="code_39" />
                  </fieldset>
                  <br clear="all" />
                </div>
                <div id="result_strip">
                  <ul class="thumbnails"></ul>
                  <button type="button" class="barcode-add"><?php echo $text_add; ?></button>
                </div>
                <div id="interactive" class="viewport"></div>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_barcode; ?></td>
              <td><input type="input" class="barcode-value" />
                <button type="button" class="barcode-add"><?php echo $text_add; ?></button></td>
            </tr>
            <tr>
              <td><?php echo $entry_barcode_list; ?></td>
              <td id="barcode-list">
                <table>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  var barcode_list = {};
  $('.barcode-add').on('click', function(){
    if ($(this).parent().find('.barcode-value').length > 1) {
      var barcode_value = $(this).parent().find('.barcode-value:checked').val();
    } else {
      var barcode_value = $(this).parent().find('.barcode-value').val();
    }
    if (barcode_value != '' && barcode_value != undefined && barcode_list[barcode_value] == undefined) {
      $('#barcode-list').append('<tr><td><input id="input_' + barcode_value + '" type="hidden" name="barcodes[]" value="' + barcode_value + '"/> ' + barcode_value + '</td><td><button id="' + barcode_value + '" type="button" onclick="$(this).parent().parent().remove();"><?php echo $text_remove; ?></button></td></tr>');
      $('input.barcode-value').val('');
      $('#result_strip > ul').html('');
      barcode_list[barcode_value] = barcode_value;
      $.ajax({
          url: 'index.php?route=catalog/barcode/checkBarcode&token=<?php echo $token; ?>&barcode_value=' + encodeURIComponent(barcode_value),
          dataType: 'json',
          success: function(data) {
            if (data.is_exist == true) {
              $('#input_' + barcode_value).remove();
              $('#' + barcode_value).after('<span style="color: red;"><?php echo $error_barcode_exist; ?></span>');
            }
          }
        });
    }
  });
</script>
<script type="text/javascript">
  $(function() {
    var App = {
        init : function() {
            Quagga.init({
                inputStream : {
                    name : "Live",
                    type : "LiveStream"
                },
                decoder : {
                    readers : ["ean_reader"]
                }
            }, function() {
                App.attachListeners();
                Quagga.start();
            });
        },
        attachListeners : function() {
            $(".controls .reader-group").on("change", "input", function(e) {
                e.preventDefault();
                Quagga.setReaders([e.target.value + "_reader"]);
            });

            $(".controls").on("click", "button.stop", function(e) {
                e.preventDefault();
                Quagga.stop();
            });
        },
        detachListeners : function() {
            $(".controls .reader-group").off("change", "input");
            $(".controls").off("click", "button.stop");
        },
        lastResult : null
    };

    App.init();

    Quagga.onProcessed(function(result) {
        var drawingCtx = Quagga.canvas.ctx.overlay,
            drawingCanvas = Quagga.canvas.dom.overlay;

        if (result) {
            if (result.boxes) {
                drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                result.boxes.filter(function (box) {
                    return box !== result.box;
                }).forEach(function (box) {
                    Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: "green", lineWidth: 2});
                });
            }

            if (result.box) {
                Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: "#00F", lineWidth: 2});
            }

            if (result.codeResult && result.codeResult.code) {
                Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
            }
        }
    });

    Quagga.onDetected(function(result) {
        var code = result.codeResult.code;

        if (App.lastResult !== code) {
            App.lastResult = code;
            var $node = null, canvas = Quagga.canvas.dom.image;

            $node = $('<li><div class="thumbnail"><div class="imgWrapper"><img /></div><div class="caption"><h4 class="code"></h4></div></div></li>');
            $node.find("img").attr("src", canvas.toDataURL());
            $node.find("h4.code").html('<input class="barcode-value" name="barcode_value" type="radio" value="' + code + '" />' + code);
            $("#result_strip ul.thumbnails").prepend($node);
        }
    });

  });
</script>
<?php echo $footer; ?>