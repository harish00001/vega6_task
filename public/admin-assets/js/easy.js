/* 
	* easy.js
	contains essential functions which makes task easier
*/

function redirect(url = "") {
	url = url == "" ? "/" : url;

	setTimeout(() => {
		window.location.href = url;
	}, 1500);
}

function refresh() {
	setTimeout(() => {
		window.location.reload();
	}, 1500);
}

function show_server_error(error = "") {
	error = error.trim() == "" ? "Server error! Please try again" : error.trim();
	new AWN().alert(error);
}

function renderImagePreview(file, wrapper_id) {
	imgURL = URL.createObjectURL(file[0].files[0]);
	console.log($(wrapper_id));
	$(wrapper_id).find("img").attr("src", imgURL);
}

function removeRenderedImage(remove_btn) {
	var fileTag = $(remove_btn).parent().parent().parent().find('[type="file"]');
	fileTag.val("");

	const imgTag = $(remove_btn).parent().parent().parent().find("img");
	const fallback = imgTag.data("fallback");
	imgTag.attr("src", fallback);

	const remove_media_id = fileTag.data("remove-id");
	console.log(remove_media_id);
	if (remove_media_id.toString().trim() != "") {
		const file_tag_name = fileTag.attr("name");

		fileTag
			.closest("form")
			.prepend(
				`<input type="hidden" name="${file_tag_name}-deleted" value="${remove_media_id}">`
			);
	}
}

function renderFilePreview(file, wrapper_id) {
	fileURL = URL.createObjectURL(file[0].files[0]);
	console.log($(wrapper_id));
	let base_url = $("meta[name=base_url]").attr("content");
	$(wrapper_id)
		.find("img")
		.attr(
			"src",
			base_url + "public/admin-assets/images/fallback/attachment.png"
		)
		.attr("title", "Click to Open");
	$(wrapper_id).find("img").wrap(`<a target="_blank" href="${fileURL}"></a>`);
}

function removeRenderedFile(remove_btn) {
	var fileTag = $(remove_btn).parent().parent().parent().find('[type="file"]');
	fileTag.val("");

	const imgTag = $(remove_btn).parent().parent().parent().find("img");
	const fallback = imgTag.data("fallback");
	imgTag.attr("src", fallback);
	imgTag.attr("title", "Please select one for preview");
	if (imgTag.parent().is("a")) {
		imgTag.unwrap();
	}

	const remove_media_id = fileTag.data("remove-id");
	console.log(remove_media_id);
	if (remove_media_id.toString().trim() != "") {
		const file_tag_name = fileTag.attr("name");

		fileTag
			.closest("form")
			.prepend(
				`<input type="hidden" name="${file_tag_name}-deleted" value="${remove_media_id}">`
			);
	}
}

$(document).ready(function () {
	// activating menu
	let child_menu = sessionStorage.getItem("active_child_menu");
	let parent_menu = sessionStorage.getItem("active_parent_menu");

	if (child_menu == null) {
		$(`[data-active-child-id=dashboard]`).addClass("active");
	} else {
		$(`[data-active-child-id=${child_menu}]`).addClass("active");
		$(`${parent_menu}`).addClass("show");
		$(`[href='${parent_menu}']`).addClass("active");
	}

	$("#navbar-nav .nav-link").click(function () {
		
		
		sessionStorage.setItem(
			"active_child_menu",
			$(this).data("active-child-id")
		);
		sessionStorage.setItem(
			"active_parent_menu",
			$(this).data("active-parent-id")
		);
	});
});

// $(document).ready(() => {
// 	$(".flatpicker_datetime").flatpickr({
// 		enableTime: true,
// 		dateFormat: "D d-M-Y h:i K",
// 	});
// });
