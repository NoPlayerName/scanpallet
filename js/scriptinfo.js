function readInfo() {
    $.get("ajax/readInfo.php", {}, function (data, status) {
        $(".readinfo_content").html(data);
    });
}