function onYouTubeIframeAPIReady(){for(var e=document.querySelectorAll(".embed-background .background-video"),t=0;t<e.length;t++){new YT.Player(e[t],{videoId:e[t].dataset.id,playerVars:{autoplay:1,controls:0,modestbranding:1,loop:1,showinfo:0,cc_load_policy:0,iv_load_policy:3,autohide:0,rel:0,playsinline:1,enablejsapi:1,playlist:e[t].dataset.id},events:{onReady:a}});function a(e){e.target.mute(),$(e.target.getIframe()).css({}),$(".background-component").addClass("playing-video")}}}$(document).ready(function(){$("body").removeClass("loading"),prism(),scrollToLinks(),accordions(),$("a").each(function(){-1===this.href.indexOf("/wp-admin/")&&-1===this.href.indexOf("/wp-login.php")||$(this).addClass("admin-link")});var e=document.createElement("script");e.src="https://www.youtube.com/iframe_api";var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t);var a={};$(function(){moment().format("YYYY-MM"),moment().add("month",1).format("YYYY-MM");$.ajax({url:"http://wordpress.localhost/wp-json/wp/v2/events?filter[meta_key]=event_start_date&filter[orderby]=meta_value_num&order=asc",dataType:"json",success:function(e){var t="[",n="";$.each(e,function(a,o){n+=a,t+="{",t+='date: "'+o.acf.event_start_date+'",',t+='title: "'+o.title.rendered+'",',t+='startDate: "'+o.acf.event_start_date+'",',t+='endDate: "'+o.acf.event_end_date+'",',t+='startTime: "'+o.acf.event_start_time+'",',t+='endTime: "'+o.acf.event_end_time+'"';for(a=0;a<e.length;a++)a===length-1?t+="}":t+="},"}),console.log(n),t+="]",console.log(t),console.log(e),a=$("#calendar").clndr({template:$("#calendar-template").html(),events:e,forceSixRows:!0})}})})});
//# sourceMappingURL=maps/scripts-min.js.map
