function onYouTubeIframeAPIReady(){for(var e=document.querySelectorAll(".embed-background .background-video"),a=0;a<e.length;a++){new YT.Player(e[a],{videoId:e[a].dataset.id,playerVars:{autoplay:1,controls:0,modestbranding:1,loop:1,showinfo:0,cc_load_policy:0,iv_load_policy:3,autohide:0,rel:0,playsinline:1,enablejsapi:1,playlist:e[a].dataset.id},events:{onReady:o}});function o(e){e.target.mute(),$(e.target.getIframe()).css({}),$(".background-component").addClass("playing-video")}}}$(document).ready(function(){$("body").removeClass("loading"),prism(),scrollToLinks(),accordions(),$("a").each(function(){-1===this.href.indexOf("/wp-admin/")&&-1===this.href.indexOf("/wp-login.php")||$(this).addClass("admin-link")});var e=document.createElement("script");e.src="https://www.youtube.com/iframe_api";var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(e,a)});
//# sourceMappingURL=maps/scripts-min.js.map
