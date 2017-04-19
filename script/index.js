function $(id) {
    return document.getElementById(id);
}

function bindEvent() {
    var b = [[],[]],
        keyword = document.getElementById('keyword').value;
    keyword = keyword.replace("搜索", "").replace(/\s/g, "");
    var keywordArr = keyword.split("/");
    for (var i = 0; i < keywordArr.length; i++) {
        for (var j = 0; j < keywordArr[i].split("-").length; j++) {
            b[i][j] = keywordArr[i].split("-")[j];
        }
    }
    var ab = $('ab').value;
    search_main("table", "WL3/add.php?wm=" + b[0][0] + "&name=" + b[0][1] + "&link=" + b[0][2] + "&dian=" + ab);
    search_main("table", "WL3/add.php?wm=" + b[1][0] + "&name=" + b[1][1] + "&link=" + b[1][2] + "&dian=" + ab);
}

function search_main(obj, url) {
    var request = new XMLHttpRequest();
    request.open("GET", url)
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            var html = '',
                data = JSON.parse(request.responseText);
            if (data.success) {
                if (data.xianding) {
                    $(obj).innerHTML = render(html, data.msg, data.text);
                } else {
                    $(obj).innerHTML = data.msg;
                }

            } else {
                $(obj).innerHTML = "出现错误：" + data.msg;
            }

        }
    }
}

function render(html, msg, text) {
    html += "<tr><td>";
    html += msg + 'keyword=' + UrlEncode(text);
    html += "</td></tr>"

}
$('search').addEventListener('click', bindEvent)