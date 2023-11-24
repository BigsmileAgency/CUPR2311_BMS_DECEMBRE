<?php
  require 'common/utils/config/images-dimensions.php';
  require 'common/utils/config/settings/functions.php';
?>

<?php include 'common/utils/css/mixin.scss.php' ?>

$border-width: 1px;
$border-color: #cccccc;
$default-color : $border-color;

*{
  @include bs();
}

<?php if ($useBoilerplate) { include '_am/boilerplates/'.$client.'/style/_boilerplate.scss.php'; } ?>

html,body{
  margin: 0;
  padding: 0;
}

#container {

  @include cnt();
  display: block;
  overflow: hidden;
  visibility: hidden;

  .abs{
    position:absolute;
  }

  .text,.txt{
    @include text_fix();
    line-height: 1;
  }

  img{
    backface-visibility: hidden;
  }

  .center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  .center-v {
    position: absolute;
    top: 50%;
    transform: translate(0%, -50%);
  }

  .center-h {
    position: absolute;
    left: 50%;
    transform: translate(-50%, 0%);
  }

  strong{
    font-weight: normal;
  }

  .border {
    pointer-events: none;
    @include init();
    @include total();
    @include bs();
    border: $border-color $border-width solid;
    z-index: 9999;
  }

  pre{
    position: absolute;
    z-index: 99999999;
    color: red;
    width: 100%;
    white-space: inherit;
    padding: 0 1em;
  }
}

#clickThroughBtn {
  @include init();
  @include total();
  display: block;
  cursor: pointer;
  color: $default-color;

  -moz-user-select: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
