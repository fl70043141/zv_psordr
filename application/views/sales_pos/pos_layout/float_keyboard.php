
<script src="<?php echo base_url('templates/plugins/float_keyboard/jqkeyboard.js');?>"></script>
<script src="<?php echo base_url('templates/plugins/float_keyboard/jqk.layout.en.js');?>"></script>
<link rel="stylesheet" href="<?php echo base_url('templates/plugins/float_keyboard/style_kb.css');?>"> 
  <script type="text/javascript">
    $(function () {
      "use strict";

      var $balloon = $("#balloon"),
        $infoTxt = $("#info-txt");

      setTimeout(function () {
        $balloon.addClass("shrink");
      }, 500);

      $infoTxt.delay(1000).fadeIn();

      $(this).click(function () {
        $("#button-hint").fadeOut();
        $balloon.fadeOut();
        $infoTxt.fadeOut();
      });

      jqKeyboard.init();
    });
  </script>