# jQuery Speech Interface

This project contains a Wordpress plugin that makes it possible for your visitors to scroll and navigate your website by talking to the browser (english only). The idea is to give people with **disabilities** (that makes it difficult or impossible to use a mouse) a better website experience.


> **NOTICE!** This plugin is mostly for fun and can't really be put into use since Chrome is the only browser implementing _-webkit-speech_ at the moment. It's also not possible to trigger the speech input without clicking on the input field, which is in contradiction to the purpose of this plugin. But as soon as the browsers adds the event _startSpeechInput_ to speech inputs this will be possible to achieve. 

## How does it work?
After that you've installed the plugin a dialog box will appear in the left corner of your website. In the dialog box there will be a small microphone-icon. Click on the icon and a recording will start (remember that this is only supported by Google Chrome at the moment).

Say one of the following commands and the magic will happen.

* "scroll down"
* "scroll up" 
* "scroll" - Will trigger the last scroll command you said
* "link X" - There will be a number in a gray circle beside every link on your page. To click on a link simply say "link" followed by the number.


## Installation on Wordpress
Dowload the [latest version](https://github.com/victorjonsson/jQuery-Speech-Interface/archives/master) to your computer. Unzip the folder in the plugin directory of your wordpress installation. Then you simply install the plugin as an ordinary plugin and you'r ready to go. 

## Custom installation 
This example requires that you have some prior knowledge about html and javascript coding. First of all upload the file jquery.speechinterface.js to your web server. Add the following to the head section of your html document (you'll have to add the path the script file).

```html
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<script src="[PATH-TO-SOME-DIRECTORY]jquery.speechinterface.js"></script>
<script>
jQuery(document).ready(function() {
  jQuery('body').speechInterface({
    debugMode : 2,
    scrollLength : jQuery(window).height() * 0.4,
  });
});
</script>
```


**Optional configuration**

* **debugMode** (int) - Either 0,1,2 depending on how much debug info you want to be displayed
* **scrollLength** (int) - How much you want the window to scroll each time the scroll command is invoked
* **posX** (int) - Where you want the dialog box to appear on the X-axis (default is 15px)
* **posY** (int) - Where you want the dialog box to appear on the Y-axis (default is 15px)
* **notSupportedMessage** - The message you want to be displayed in browsers that doesn't support -webkit-speech
