!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=1)}([function(e,t){e.exports=window.ctEvents},function(e,t,n){"use strict";n.r(t),n.d(t,"onDocumentLoaded",(function(){return a}));var r=n(0),o=n.n(r),c=function(e,t){var n=t.screen,r=void 0===n?"login":n;e.querySelector("ul")&&e.querySelector("ul .ct-".concat(r))&&(e.querySelector("ul .active").classList.remove("active"),e.querySelector("ul .ct-".concat(r)).classList.add("active")),e.querySelector('[class*="-form"].active').classList.remove("active"),e.querySelector(".ct-".concat(r,"-form")).classList.add("active")},u=function(){Array.from(document.querySelectorAll(".ct-header-account > a[href]")).map((function(e){e.hasSearchEventListener||(e.hasSearchEventListener=!0,e.addEventListener("click",(function(t){c(document.querySelector(e.hash),{screen:"login"}),o.a.trigger("ct:overlay:handle-click",{e:t,el:e,options:{isModal:!0}})})),e.hash&&function(e){e&&["login","register","forgot-password"].map((function(t){Array.from(e.querySelectorAll(".ct-".concat(t))).map((function(n){n.addEventListener("click",(function(n){n.preventDefault(),c(e,{screen:t})}))}))}))}(document.querySelector(e.hash)))}))},a=function(e){/comp|inter|loaded/.test(document.readyState)?e():document.addEventListener("DOMContentLoaded",e,!1)};a((function(){u()}))}]);