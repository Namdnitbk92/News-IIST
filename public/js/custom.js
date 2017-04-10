!function(e){"use strict";e.FileDialog=function(a){var o=e.extend(e.FileDialog.defaults,a),t=e(["<div class='modal fade'>","    <div class='modal-dialog'>","        <div class='modal-content'>","            <div class='modal-header'>","                <button type='button' class='close' data-dismiss='modal'>","                    <span aria-hidden='true'>&times;</span>","                    <span class='sr-only'>",o.cancel_button,"                    </span>","                </button>","                <h4 class='modal-title'>",o.title,"                </h4>","            </div>","            <div class='modal-body'>","                <input type='file' />","                <div class='bfd-dropfield'>","                    <div class='bfd-dropfield-inner'>",o.drag_message,"                    </div>","                </div>","                <div class='container-fluid bfd-files'>","                </div>","            </div>","            <div class='modal-footer'>","                <button type='button' class='btn btn-primary bfd-ok'>",o.ok_button,"                </button>","                <button type='button' class='btn btn-default bfd-cancel'","                                data-dismiss='modal'>",o.cancel_button,"                </button>","            </div>","        </div>","    </div>","</div>"].join("")),n=!1,r=e("input:file",t),i=e(".bfd-dropfield",t),s=e(".bfd-dropfield-inner",i);s.css({height:o.dropheight,"padding-top":o.dropheight/2-32}),r.attr({accept:o.accept,multiple:o.multiple}),i.on("click.bfd",function(){r.trigger("click")});var d=[],l=[],c=function(a){var n,r,i=new FileReader;l.push(i),i.onloadstart=function(){},i.onerror=function(e){e.target.error.code!==e.target.error.ABORT_ERR&&n.parent().html(["<div class='bg-danger bfd-error-message'>",o.error_message,"</div>"].join("\n"))},i.onprogress=function(a){var o=Math.round(100*a.loaded/a.total)+"%";n.attr("aria-valuenow",a.loaded),n.css("width",o),e(".sr-only",n).text(o)},i.onload=function(e){a.content=e.target.result,d.push(a),n.removeClass("active")};var s=e(["<div class='col-xs-7 col-sm-4 bfd-info'>","    <span class='glyphicon glyphicon-remove bfd-remove'></span>&nbsp;","    <span class='glyphicon glyphicon-file'></span>&nbsp;"+a.name,"</div>","<div class='col-xs-5 col-sm-8 bfd-progress'>","    <div class='progress'>","        <div class='progress-bar progress-bar-striped active' role='progressbar'","            aria-valuenow='0' aria-valuemin='0' aria-valuemax='"+a.size+"'>","            <span class='sr-only'>0%</span>","        </div>","    </div>","</div>"].join(""));n=e(".progress-bar",s),e(".bfd-remove",s).tooltip({container:"body",html:!0,placement:"top",title:o.remove_message}).on("click.bfd",function(){var e=d.indexOf(a);e>=0&&d.pop(e),r.fadeOut();try{i.abort()}catch(o){}}),r=e("<div class='row'></div>"),r.append(s),e(".bfd-files",t).append(r),i["readAs"+o.readAs](a)},f=function(e){Array.prototype.forEach.apply(e,[c])};return r.change(function(e){e=e.originalEvent;var a=e.target.files;f(a);var o=r.clone(!0);r.replaceWith(o),r=o}),i.on("dragenter.bfd",function(){s.addClass("bfd-dragover")}).on("dragover.bfd",function(e){e=e.originalEvent,e.stopPropagation(),e.preventDefault(),e.dataTransfer.dropEffect="copy"}).on("dragleave.bfd drop.bfd",function(){s.removeClass("bfd-dragover")}).on("drop.bfd",function(e){e=e.originalEvent,e.stopPropagation(),e.preventDefault();var a=e.dataTransfer.files;0===a.length,f(a)}),e(".bfd-ok",t).on("click.bfd",function(){var a=e.Event("files.bs.filedialog");a.files=d,t.trigger(a),n=!0,t.modal("hide")}),t.on("hidden.bs.modal",function(){if(l.forEach(function(e){try{e.abort()}catch(a){}}),!n){var a=e.Event("cancel.bs.filedialog");t.trigger(a)}t.remove()}),e(document.body).append(t),t.modal(),t},e.FileDialog.defaults={accept:"*",cancel_button:"Close",drag_message:"Drop files here",dropheight:400,error_message:"An error occured while loading file",multiple:!0,ok_button:"OK",readAs:"DataURL",remove_message:"Remove&nbsp;file",title:"Load file(s)"}}(jQuery);
/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    var CURRENT_URL = window.location.href.split('?')[0],
    $BODY = $('body'),
    $MENU_TOGGLE = $('#menu_toggle'),
    $SIDEBAR_MENU = $('#sidebar-menu'),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
    $FOOTER = $('footer');
    // Sidebar
    // TODO: This is some kind of easy fix, maybe we can improve this
    var setContentHeight = function () {
        // reset height
        $RIGHT_COL.css('min-height', $(window).height());

        var bodyHeight = $BODY.outerHeight(),
            footerHeight = $BODY.hasClass('footer_fixed') ? 0 : $FOOTER.height(),
            leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
            contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;

        // normalize content
        contentHeight -= $NAV_MENU.height() + footerHeight;

        $RIGHT_COL.css('min-height', contentHeight);
    };

    $SIDEBAR_MENU.find('a').on('click', function(ev) {
        var $li = $(this).parent();

        if ($li.is('.active')) {
            $li.removeClass('active active-sm');
            $('ul:first', $li).slideUp(function() {
                setContentHeight();
            });
        } else {
            // prevent closing menu if we are on child menu
            if (!$li.parent().is('.child_menu')) {
                $SIDEBAR_MENU.find('li').removeClass('active active-sm');
                $SIDEBAR_MENU.find('li ul').slideUp();
            }
            
            $li.addClass('active');

            $('ul:first', $li).slideDown(function() {
                setContentHeight();
            });
        }
    });
    // toggle small or large menu
    $MENU_TOGGLE.on('click', function() {
        if ($BODY.hasClass('nav-md')) {
            $SIDEBAR_MENU.find('li.active ul').hide();
            $SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
        } else {
            $SIDEBAR_MENU.find('li.active-sm ul').show();
            $SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
        }

        $BODY.toggleClass('nav-md nav-sm');

        setContentHeight();
    });

    // check active menu
    $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');

    $SIDEBAR_MENU.find('a').filter(function () {
        return this.href == CURRENT_URL;
    }).parent('li').addClass('current-page').parents('ul').slideDown(function() {
        setContentHeight();
    }).parent().addClass('active');

    // recompute content when resizing
    $(window).smartresize(function(){  
        setContentHeight();
    });

    setContentHeight();

    // fixed sidebar
    if ($.fn.mCustomScrollbar) {
        $('.menu_fixed').mCustomScrollbar({
            autoHideScrollbar: true,
            theme: 'minimal',
            mouseWheel:{ preventDefault: true }
        });
    }
});
// /Sidebar

// Panel toolbox
$(document).ready(function() {
    $('.collapse-link').on('click', function() {
        var $BOX_PANEL = $(this).closest('.x_panel'),
            $ICON = $(this).find('i'),
            $BOX_CONTENT = $BOX_PANEL.find('.x_content');
        
        // fix for some div with hardcoded fix class
        if ($BOX_PANEL.attr('style')) {
            $BOX_CONTENT.slideToggle(200, function(){
                $BOX_PANEL.removeAttr('style');
            });
        } else {
            $BOX_CONTENT.slideToggle(200); 
            $BOX_PANEL.css('height', 'auto');  
        }

        $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    });

    $('.close-link').click(function () {
        var $BOX_PANEL = $(this).closest('.x_panel');

        $BOX_PANEL.remove();
    });
});
// /Panel toolbox

// Tooltip
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });
});
// /Tooltip

// Progressbar
if ($(".progress .progress-bar")[0]) {
    $('.progress .progress-bar').progressbar();
}
// /Progressbar

// Switchery
$(document).ready(function() {
    if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#26B99A'
            });
        });
    }
});
// /Switchery

// Accordion
$(document).ready(function() {
    $(".expand").on("click", function () {
        $(this).next().slideToggle(200);
        $expand = $(this).find(">:first-child");

        if ($expand.text() == "+") {
            $expand.text("-");
        } else {
            $expand.text("+");
        }
    });
});

// NProgress
if (typeof NProgress != 'undefined') {
    $(document).ready(function () {
        NProgress.start();
    });

    $(window).on('load', function () {
        setTimeout(function(){NProgress.done();}, 1000);
    });
}
/**
 * Resize function without multiple trigger
 * 
 * Usage:
 * $(window).smartresize(function(){  
 *     // code here
 * });
 */
(function($,sr){
    // debouncing function from John Hann
    // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
    var debounce = function (func, threshold, execAsap) {
      var timeout;

        return function debounced () {
            var obj = this, args = arguments;
            function delayed () {
                if (!execAsap)
                    func.apply(obj, args);
                timeout = null; 
            }

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 100); 
        };
    };

    // smartresize 
    jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');
//# sourceMappingURL=custom.js.map

/**
 * Created by Kupletsky Sergey on 05.11.14.
 *
 * Material Design Responsive Table
 * Tested on Win8.1 with browsers: Chrome 37, Firefox 32, Opera 25, IE 11, Safari 5.1.7
 * You can use this table in Bootstrap (v3) projects. Material Design Responsive Table CSS-style will override basic bootstrap style.
 * JS used only for table constructor: you don't need it in your project
 */

$(document).ready(function() {

    var table = $('#table');

    // Table bordered
    $('#table-bordered').change(function() {
        var value = $( this ).val();
        table.removeClass('table-bordered').addClass(value);
    });

    // Table striped
    $('#table-striped').change(function() {
        var value = $( this ).val();
        table.removeClass('table-striped').addClass(value);
    });
  
    // Table hover
    $('#table-hover').change(function() {
        var value = $( this ).val();
        table.removeClass('table-hover').addClass(value);
    });

    // Table color
    $('#table-color').change(function() {
        var value = $(this).val();
        table.removeClass(/^table-mc-/).addClass(value);
    });
});

// jQuery’s hasClass and removeClass on steroids
// by Nikita Vasilyev
// https://github.com/NV/jquery-regexp-classes
(function(removeClass) {

    jQuery.fn.removeClass = function( value ) {
        if ( value && typeof value.test === "function" ) {
            for ( var i = 0, l = this.length; i < l; i++ ) {
                var elem = this[i];
                if ( elem.nodeType === 1 && elem.className ) {
                    var classNames = elem.className.split( /\s+/ );

                    for ( var n = classNames.length; n--; ) {
                        if ( value.test(classNames[n]) ) {
                            classNames.splice(n, 1);
                        }
                    }
                    elem.className = jQuery.trim( classNames.join(" ") );
                }
            }
        } else {
            removeClass.call(this, value);
        }
        return this;
    }

})(jQuery.fn.removeClass);

//# sourceMappingURL=custom.js.map
