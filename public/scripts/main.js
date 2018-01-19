(function($){$.fn.bindCheckboxes=function(callbacks){var wrap=this;if(!callbacks)callbacks={};wrap.bind("update",function(e,id){var total=wrap.find('input[data-check="'+id+'"]');var checked=total.filter(":checked");var values=[];checked.each(function(){var v=$(this).attr("value");if(values.indexOf(v)<0)values.push(v)});wrap.find('[data-check-toggle="'+id+'"]').trigger("update",[checked.length,total.length]);wrap.find('[data-check-count="'+id+'"]').trigger("update",[checked.length,total.length]);wrap.find('[data-check-data="'+id+'"]').trigger("update",[values]);if(callbacks[id]&&callbacks[id].call){callbacks[id](total,values)}});wrap.find("[data-check-cancel]").on("click",function(e,values){var that=$(this);wrap.find('input[data-check="'+that.data("check-cancel")+'"]').not(":disabled").prop("checked",false).trigger("update")});wrap.find("input[data-check-toggle]").on("change",function(){var that=$(this);wrap.find('input[data-check="'+that.data("check-toggle")+'"]').not(":disabled").prop("checked",that.prop("checked")).trigger("update")}).on("update",function(e,checked,total){var that=$(this);that.prop("disabled",total==0);that.prop("indeterminate",checked>0&&checked<total);that.prop("checked",checked==total);if(that.is("[data-check]"))wrap.trigger("update",[that.data("check")])});wrap.find("[data-check-count]").on("update",function(e,checked,total){$(this).text(checked)});wrap.find("[data-check-data]").on("update",function(e,values){$(this).addClass("js-post").data("post",{values:values}).prop("disabled",values.length==0)});var lastIndex={};wrap.find("input[data-check]").on("update",function(e,shift){var that=$(this);var items=wrap.find('[data-check="'+that.data("check")+'"]');if(typeof lastIndex[that.data("check")]==="undefined")lastIndex[that.data("check")]=-1;var last=lastIndex[that.data("check")];if(shift&&last>-1){var pos=items.index(that);var targets=pos<last?items.slice(pos,last+1):items.slice(last,pos+1);targets.prop("checked",that.is(":checked"))}else if(!shift)lastIndex[that.data("check")]=items.index(that);wrap.trigger("update",[that.data("check")])}).on("click",function(e){$(this).trigger("update",[e.shiftKey])}).trigger("change")}})(jQuery);(function($){$.fn.bindMisc=function(){var wrap=this;wrap.find('[data-toggle="tooltip"]').tooltip();var dialog=$("#dialog").modal({show:false});wrap.find("[data-confirm]").on("click",function(e,confirmed){if(confirmed)return true;e.preventDefault();var that=$(this);dialog.find(".js-dialog-text").html(that.data("confirm"));dialog.find(".js-dialog-confirm").off().click(function(e){dialog.hide("hide");that.trigger("click",[true])});dialog.modal("show")});wrap.find("[data-focus]").on("click",function(){var that=$(this);$(that.data("focus")).focus()});wrap.find(".js-focus-select").on("focus",function(){this.select()});wrap.find(".js-live-submit").on("change",function(){var that=$(this);if(that.is(":valid"))that.parents("form").submit()});wrap.find("[data-auto-dismiss]").each(function(){var that=$(this);setTimeout(function(){that.slideUp(150,function(){that.remove()})},that.data("auto-dismiss"))})}})(jQuery);(function($){$.fn.bindModals=function(){var wrap=this;var handler=function(e){e.preventDefault();var that=$(this);var url=that.data("modal");var req={async:true,headers:{"X-REFERER-URL":encodeURIComponent(location.href)}};if(that.data("post")){req.method="POST";req.data=that.data("post")}else if(that.is("form")){req.method="POST";req.data=that.serialize()}$.ajax(url,req).fail(function(xhr,status,error){console.log(error)}).done(function(data,status,xhr){var redirect=xhr.getResponseHeader("X-REDIRECT-URL");if(redirect){location.href=redirect}else{$(".modal").modal("hide");var html=$("<div>").append($(data.responseText||data).find(".js-modal-wrap")).html();html='<div class="modal-dialog"><div class="modal-content">'+html+"</div></div>";var modal=$('<div class="modal fade">').html(html).attr("data-async",true).appendTo("body");modal.bindAll();modal.on("hidden.bs.modal",function(){modal.remove()}).modal("show")}})};wrap.find("[data-modal]").not("form").on("click",handler);wrap.find("form[data-modal]").on("submit",handler)}})(jQuery);(function($){$.fn.bindAll=function(){var wrap=this;wrap.bindMisc();wrap.bindModals();wrap.bindCheckboxes({cruditems:function(items,values){var checked=items.filter(":checked");var parents=items.parents(".Selectable").removeClass("is-selected");var actions=$(".Selectable-actions").removeClass("is-open");if(checked.length){checked.parents(".Selectable").addClass("is-selected");actions.addClass("is-open")}}})};$(function(){$("body").bindAll()})})(jQuery);