<!DOCTYPE html>
<html>
<head>
  <?php wp_head(); 

    $img_url = RECAPTCHA_FOR_ALLURL.'images/background.jpg';
    $recaptcha_for_all_background = trim(sanitize_text_field(get_option('recaptcha_for_all_background', 'yes')));

  ?>
  <style>
    html { 

        <?php if($recaptcha_for_all_background == 'yes')
              echo 'background: url("'.esc_url($img_url).'") no-repeat center center fixed;';
        ?> 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }
      .recaptcha_for_all_box {
        width: 600px;
        max-width: 90%;
        padding: 20px;
        border: 1px solid gray;
        margin: 0px auto;
        text-align: center;
        background-color: white;
        font-size: 20px;
      }
      body {
        <?php
        if($recaptcha_for_all_background != 'yes')
          echo 'background-color: gray !important; ';
        ?>
        max-width: 100%;
        margin: 0px auto;
        text-align: center;
        background: transparent;

      }
      @media only screen and (max-width: 780px) {
        .recaptcha_for_all_box {
           font-size: 16pt;
           background: white;
        }
        #recaptcha_for_all_button {
          font-size: 20pt;
        }
      }
    </style>


</head>
<?php
$recaptcha_for_all_message = trim(sanitize_text_field(get_option('recaptcha_for_all_message', '')));
$recaptcha_for_all_text_button = trim(sanitize_text_field(get_option('recaptcha_for_all_button', '')));

if(empty($recaptcha_for_all_text_button))
   $recaptcha_for_all_text_button = 'I Agree';
if(empty($recaptcha_for_all_message)) {
    $recaptcha_for_all_message = "We use cookies and javascript to improve the user experience and personalise content and ads, to provide social media 
    features and to analyse our traffic. 
    We also share information about your use of our site with our social media, 
    advertising and analytics partners who may combine it with other information 
    that you’ve provided to them or that they’ve collected from your use of their services.
    <br>
    If you disagree, please, press BACK on your browser.";
}
?>
<body>

<!--
  <div class="recaptcha_for_all_container" id="recaptcha_for_all_main-content">
-->

    <div class="recaptcha_for_all_box">
      <h3>Cookies</h3>
      <?php echo esc_html($recaptcha_for_all_message); ?>
      <form id="recaptcha_for_all" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="POST">
        <input type="hidden" id="sitekey" name="sitekey" value="<?php echo esc_html($recaptcha_for_all_sitekey);?>" />
        <br>
        <button id="recaptcha_for_all_button" name="recaptcha_for_all_button" type="submit"><?php echo esc_html($recaptcha_for_all_text_button);?></button>
      </form>
    </div>

<!--  </div> -->

  <?php wp_footer(); ?>
</body>
</html>