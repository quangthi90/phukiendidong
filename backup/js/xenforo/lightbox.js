/*
 * XenForo lightbox.min.js
 * Copyright 2010-2014 XenForo Ltd.
 * Released under the XenForo License Agreement: http://xenforo.com/license-agreement
 */
(function(a,p,q){XenForo.LightBox=function(r,u){var o=a("#LightBox").prop("unselectable",!0),m=o.find(".imageNav"),f=a("#LbImg"),j=o.find(".imageContainer"),n=[],g=a("#LbThumbs"),i=g.data("thumbheight"),k=0,l=0,s="";a("#LbPrev, #LbNext, #LightBox .imageContainer").click(a.context(function(b){b.preventDefault();this.shift(a(b.target).closest(".imageNav").attr("id")=="LbPrev"?-1:1);return!1},this));this.bindNav=function(){a(q).bind({"keydown.lightbox":a.context(function(a){switch(a.keyCode){case 37:case 38:return a.preventDefault(),
this.shift(-1);case 39:case 40:return a.preventDefault(),this.shift(1)}},this),"wheel.lightbox":a.context(function(a,d){d&&(a.preventDefault(),this.shift(d<0?1:-1))},this)})};this.unbindNav=function(){a(q).unbind(".lightbox")};this.shift=function(b){var d=g.find("li:not(#LbThumbTemplate) a");d.each(a.context(function(c,g){if(a(g).data("src")==f.attr("src"))return c+=b,c<0?c=d.length-1:c>=d.length&&(c=0),d.eq(c).triggerHandler("click",[!0]),!1},this))};this.setThumbStrip=function(b){console.info("setThumbStrip(%o)",
b);var d=a("#LbThumbTemplate"),c=this;n=[];g.find("li").not(d).remove();l=0;b.find("img.LbImage").each(a.context(function(b,e){var h=a(e),f=h.parent(".LbTrigger").attr("href")||h.attr("src");if(h.parents(".ignored").length)return this;a.inArray(f,n)==-1&&(n.push(f),setTimeout(function(){preLoader=new Image;preLoader.src=f},1),d.clone().removeAttr("id").appendTo(g).find("a").data("src",f).data("el",h).click(a.context(function(a,b){a.preventDefault();this.setImage(h,b?0:XenForo.speed.fast)},this)).find("img").load(function(){var b=
this;setTimeout(function(){var c=a(b),d=c.width();c.height()>d?(c.css("width",i),c.css("top",(c.height()-i)/2*-1)):(c.css("height",i),c.css(XenForo.switchStringRTL("left"),(c.width()-i)/2*-1));c.css("visibility","visible")},0)}).error(function(){c.removeFailedThumb(this)}).attr("src",h.attr("src")))},this));switch(n.length){case 0:return!1;case 1:m.hide();break;default:m.show()}return this};this.removeFailedThumb=function(b){a(b).closest("li").remove();switch(g.find("li:not(#LbThumbTemplate)").length){case 0:return r.close(),
!1;case 1:m.hide();break;default:m.show()}this.setDimensions(!0);this.selectThumb(s,0);return!0};this.setImage=function(b,d){if(b===void 0)return j.find("img.LbImg").not(f).remove(),this;var c,t=b.closest(u),e=b.parent(".LbTrigger").attr("href")||b.attr("src"),h=this;c=f.clone(!0).removeAttr("id").attr("src","about:blank");var i=a.context(function(){j.find("img.LbImg").not(f).remove();c.css({maxWidth:j.width(),maxHeight:j.height()});c.prependTo(f.parent()).css({position:"static","margin-top":(j.height()-
c.height())/2,visibility:"visible"});c.attr("src",e);f.attr("src",e)},this);c.one("load",function(){setTimeout(i,0)}).one("error",function(){g.find("li:not(#LbThumbTemplate) a").each(function(b,c){a(c).data("src")==e&&h.removeFailedThumb(c)&&h.setImage(a(g.find("li:not(#LbThumbTemplate) a").get(Math.max(0,b-1))).data("el"),0)})});c.attr("src",e);this.selectThumb(e,d);this.setImageInfo(t,e);this.setContentLink(t);return this};this.selectThumb=function(b,d){var c=g.find("li:not(#LbThumbTemplate) a");
c.find("img").fadeTo(0,0.5);b===void 0&&(b=f.attr("src"));c.each(function(f,e){if(a(e).data("src")==b){s=b;l=f*(i+3);g.stop();if(d){var h={};h[XenForo.switchStringRTL("left")]=k-l;g.animate(h,d,function(){a(e).find("img").fadeTo(d/6,1)})}else g.css(XenForo.switchStringRTL("left"),k-l),a(e).find("img").fadeTo(0,1);a("#LbSelectedImage").text(f+1);a("#LbTotalImages").text(c.length);return!1}});return this};this.setDimensions=function(b){var d=a(p).height()-r.getConf().top*2-a("#LbUpper").outerHeight()-
a("#LbLower").outerHeight();j.css({height:d,lineHeight:0});o.find("img.LbImg").css({maxWidth:j.width(),maxHeight:d});k=Math.max(0,(g.parent().width()-(i+2))/2);b&&console.log("thumbOffset = "+k+", thumbShift = "+l);g.css(XenForo.switchStringRTL("left"),k-l);a("#LbReveal").css(XenForo.switchStringRTL("left"),k).show();return this};this.setImageInfo=function(b,d){var c=b.find("a.avatar"),f=c.find("img"),e=!1;if(f.length)e=f.attr("src");else if(e=c.find("span.img").css("background-image"))e=e.replace(/^url\(("|'|)([^\1]+)\1\)$/i,
"$2");e?a("#LbAvatar img").attr("src",e):a("#LbAvatar img").attr("src","rgba.php?r=0&g=0&b=0");a("#LbUsername").text(b.data("author"));a("#LbDateTime").text(b.find(".DateTime:first").text());a("#LbNewWindow").attr("href",d);return this};this.setContentLink=function(b){(b=b.attr("id"))?a("#LbContentLink, #LbDateTime").attr("href",p.location.href).attr("hash","#"+b):a("#LbContentLink").text("").removeAttr("href");return this}}})(jQuery,this,document);
