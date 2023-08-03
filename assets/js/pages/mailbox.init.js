import ClassicEditor from "../../libs/@ckeditor/ckeditor5-build-classic/build/ckeditor";
import bootstrap from "../../libs/bootstrap/js/bootstrap.bundle.min";

let primaryMailList = "", socialmaillist = "", promotionsmaillist = "";
const loader = document.querySelector("#elmLoader");
let url = "/";
const api = new XMLHttpRequest;
const currentChatId = "users-chat";
const triggerTabList = document.querySelectorAll("#mail-filter-navlist .nav-tabs button");
let markAsUnreadBtn = document.querySelector(".mark-as-unread");
let favouriteTBtn = document.querySelector(".favourite-btn");

const getJSON = function (e, t) {
    api.open("GET", url + e, !0);
    console.log("url + e: " + url + e);
    api.responseType = "json";
    api.onload = function () {
        const e = api.status;
        if (200 === e) {
            loader.innerHTML = "";
            t(null, api.response);
        } else {
            console.log("Quelque chose s'est mal passé: " + api.response);
            t(e, api.response)
        }
    };
    api.send();
};

function printMailRow(box, a, c, e, l) {
    document.getElementById(box).innerHTML += '<li class="' + a + '"><div class="col-mail col-mail-1"><div class="form-check checkbox-wrapper-mail fs-14"><input class="form-check-input" type="checkbox" value="' + e.id + '" id="checkbox-' + e.id + '"><label class="form-check-label" for="checkbox-' + e.id + '"></label></div><input type="hidden" value=' + e.userImg + ' class="mail-userimg" /><button type="button" class="btn avatar-xs p-0 favourite-btn fs-15 ' + l + '"><i class="ri-star-fill"></i></button><a href="javascript: void(0);" class="title"><span class="title-name">' + e.name + "</span> " + c + '</a></div><div class="col-mail col-mail-2"><a href="javascript: void(0);" class="subject"><span class="subject-title">' + e.title + '</span> - <span class="teaser">' + e.plain_text + '</span><div class="html-body" style="display: none;">' + e.html_text + '</div></a><div class="date"><span class="badge bg-info">' + e.date + '</span></div></div><span class="mail-id" style="display: none;">' + e.id + '"</span><span class="mail-readed" style="display: none;">' + (e.readed ? 1 : 0) + '"</span><span class="mail-starred" style="display: none;">' + (e.starred ? 1 : 0) + '"</span></li>';
}

function loadMailData(e) {
    document.querySelector('#mail-filter-navlist button[data-bs-target="#pills-primary"]').click();
    document.querySelector("#mail-list").innerHTML = "";
    let count_readed = 0, count_starred = 0, count_typed_readed = 0, count_typed_starred = 0;
    Array.from(e).forEach(function (e, t) {
        const a = e.readed ? "" : "unread";
        const l = e.starred ? "active" : "";
        const c = e.counted ? "(" + e.counted + ")" : "";
        if (a === "unread") {
            count_readed++;
        }
        if (l === "") {
            count_starred++;
        }
        if (a === "unread") {
            count_typed_readed++;
        }
        if (l === "") {
            count_typed_starred++;
        }
        printMailRow("mail-list", a, c, e, l);
        favouriteBtn();
        emailDetailShow();
        emailDetailChange();
        checkBoxAll();
    });
    document.querySelector(".message-count").innerHTML = Array.from(e).length;
    document.querySelector(".inbox-mail-count").innerHTML = count_readed;
}

function loadSocialMailData(e) {
    let count_readed = 0, count_starred = 0, count_typed_readed = 0, count_typed_starred = 0;
    Array.from(e).forEach(function (e, t) {
        const a = e.readed ? "" : "unread";
        const l = e.starred ? "active" : "";
        const c = e.counted ? "(" + e.counted + ")" : "";
        if (a === "unread") {
            count_readed++;
        }
        if (l === "") {
            count_starred++;
        }
        if (a === "unread") {
            count_typed_readed++;
        }
        if (l === "") {
            count_typed_starred++;
        }
        printMailRow("social-mail-list", a, c, e, l);

        emailDetailShow();
        emailDetailChange();
        checkBoxAll();
    });
    //document.querySelector(".message-count").innerHTML = Array.from(e).length;
    //document.querySelector(".inbox-mail-count").innerHTML = count_readed;
}

function loadPromotionsMailData(e) {
    let count_readed = 0, count_starred = 0, count_typed_readed = 0, count_typed_starred = 0;
    Array.from(e).forEach(function (e, t) {
        const a = e.readed ? "" : "unread";
        const l = e.starred ? "active" : "";
        const c = e.counted ? "(" + e.counted + ")" : "";
        if (a === "unread") {
            count_readed++;
        }
        if (l === "") {
            count_starred++;
        }
        if (a === "unread") {
            count_typed_readed++;
        }
        if (l === "") {
            count_typed_starred++;
        }
        printMailRow("promotions-mail-list", a, c, e, l);
        emailDetailShow();
        emailDetailChange();
        checkBoxAll();
    });
    //document.querySelector(".message-count").innerHTML = Array.from(e).length;
    //document.querySelector(".inbox-mail-count").innerHTML = count_readed;
}

function favouriteBtn() {
    Array.from(document.querySelectorAll(".favourite-btn")).forEach(function (e) {
        e.addEventListener("click", function () {
            e.classList.contains("active") ? e.classList.remove("active") : e.classList.add("active")
        })
    })
}

function emailDetailShow() {
    let a = document.getElementsByTagName("body")[0],
        t = (Array.from(document.querySelectorAll(".message-list a")).forEach(function (e) {
            e.addEventListener("click", function (t) {
                a.classList.add("email-detail-show"), Array.from(document.querySelectorAll(".message-list li.unread")).forEach(function (e) {
                    e.classList.contains("unread") && t.target.closest("li").classList.remove("unread")
                })
            })
        }), Array.from(document.querySelectorAll(".close-btn-email")).forEach(function (e) {
            e.addEventListener("click", function () {
                a.classList.remove("email-detail-show")
            })
        }), !1), l = document.getElementsByClassName("email-menu-sidebar");
    Array.from(document.querySelectorAll(".email-menu-btn")).forEach(function (e) {
        e.addEventListener("click", function () {
            Array.from(l).forEach(function (e) {
                e.classList.add("menubar-show"), t = !0
            })
        })
    }), window.addEventListener("click", function (e) {
        document.querySelector(".email-menu-sidebar").classList.contains("menubar-show") && (t || document.querySelector(".email-menu-sidebar").classList.remove("menubar-show"), t = !1)
    }), favouriteBtn()
}

function checkBoxAll() {
    Array.from(document.querySelectorAll(".checkbox-wrapper-mail input")).forEach(function (e) {
        e.addEventListener("click", function (e) {
            1 === e.target.checked ? e.target.closest("li").classList.add("active") : e.target.closest("li").classList.remove("active")
        })
    });
    const e = document.querySelectorAll(".tab-pane.show .checkbox-wrapper-mail input");

    function a() {
        const e = document.querySelectorAll(".tab-pane.show .checkbox-wrapper-mail input"),
            t = document.querySelectorAll(".tab-pane.show .checkbox-wrapper-mail input:checked").length;
        Array.from(e).forEach(function (e) {
            e.checked = !0, e.parentNode.parentNode.parentNode.classList.add("active")
        }), document.getElementById("email-topbar-actions").style.display = 0 < t ? "none" : "block", 0 < t ? Array.from(e).forEach(function (e) {
            e.checked = !1, e.parentNode.parentNode.parentNode.classList.remove("active")
        }) : Array.from(e).forEach(function (e) {
            e.checked = !0, e.parentNode.parentNode.parentNode.classList.add("active")
        }), this.onclick = l, removeItems()
    }

    function l() {
        const e = document.querySelectorAll(".tab-pane.show .checkbox-wrapper-mail input"),
            t = document.querySelectorAll(".tab-pane.show .checkbox-wrapper-mail input:checked").length;
        Array.from(e).forEach(function (e) {
            e.checked = !1, e.parentNode.parentNode.parentNode.classList.remove("active")
        }), document.getElementById("email-topbar-actions").style.display = 0 < t ? "none" : "block", 0 < t ? Array.from(e).forEach(function (e) {
            e.checked = !1, e.parentNode.parentNode.parentNode.classList.remove("active")
        }) : Array.from(e).forEach(function (e) {
            e.checked = !0, e.parentNode.parentNode.parentNode.classList.add("active")
        }), this.onclick = a
    }

    Array.from(e).forEach(function (e) {
        e.addEventListener("click", function (e) {
            var t = document.querySelectorAll(".tab-pane.show .checkbox-wrapper-mail input"),
                a = document.getElementById("checkall"),
                l = document.querySelectorAll(".tab-pane.show .checkbox-wrapper-mail input:checked").length;
            a.checked = 0 < l, a.indeterminate = 0 < l && l < t.length, e.target.closest("li").classList.contains("active"), document.getElementById("email-topbar-actions").style.display = 0 < l ? "block" : "none"
        })
    }), document.getElementById("checkall").onclick = a
}

favouriteBtn();
ClassicEditor.create(document.querySelector("#email-editor")).then(function (e) {
    e.ui.view.editable.element.style.height = "200px"
}).catch(function (e) {
    console.log(e)
});

function loadAllBoxes() {
    document.querySelector("#mail-list").innerHTML = "";
    loader.innerHTML = '<div id="elmLoader" class="text-center"><div class="spinner-border text-success avatar-sm" role="status"><span class="visually-hidden">Chargement...</span></div></div>';
    getJSON("build/assets/json/mail-list.json", function(e,t) {
        if (e !== null) {
            console.log("Quelque chose s'est mal passé: " + e)
        } else {
            primaryMailList = t[0].primary;
            socialmaillist = t[0].social;
            promotionsmaillist = t[0].promotions;
            loadMailData(primaryMailList);
            loadSocialMailData(socialmaillist);
            loadPromotionsMailData(promotionsmaillist);
        }
    });
}

function scrollToBottom(a) {
    setTimeout(function () {
        const e = document.getElementById(a).querySelector("#chat-conversation .simplebar-content-wrapper") ? document.getElementById(a).querySelector("#chat-conversation .simplebar-content-wrapper") : "",
            t = document.getElementsByClassName("chat-conversation-list")[0] ? document.getElementById(a).getElementsByClassName("chat-conversation-list")[0].scrollHeight - window.innerHeight + 750 : 0;
        t && e.scrollTo({top: t, behavior: "smooth"})
    }, 100)
}

function removeItems() {
    document.getElementById("removeItemModal").addEventListener("show.bs.modal", function (e) {
        document.getElementById("delete-record").addEventListener("click", function () {
            Array.from(document.querySelectorAll(".message-list li")).forEach(function (e) {
                var t, a;
                e.classList.contains("active") && (t = e.querySelector(".form-check-input").value, a = t, primaryMailList = primaryMailList.filter(function (e) {
                    return e.id !== a
                }), e.remove())
            }), document.getElementById("btn-close").click(), document.getElementById("email-topbar-actions") && (document.getElementById("email-topbar-actions").style.display = "none"), checkall.indeterminate = !1, checkall.checked = !1
        })
    })
}

function removeSingleItem() {
    var a;
    document.querySelectorAll(".remove-mail").forEach(function (t) {
        t.addEventListener("click", function (e) {
            a = t.getAttribute("data-remove-id"), document.getElementById("delete-record").addEventListener("click", function () {
                var t;
                t = a, loadMailData(primaryMailList = primaryMailList.filter(function (e) {
                    return e.id !== t
                }), null), document.getElementById("close-btn-email").click()
            })
        })
    })
}

loadAllBoxes();
scrollToBottom(currentChatId);
removeItems();
removeSingleItem();

let markAllReadBtn = document.getElementById("mark-all-read"),
    dummyUserImage = (markAllReadBtn.addEventListener("click", function (e) {
        0 === document.querySelectorAll(".message-list li.unread").length && (document.getElementById("unreadConversations").style.display = "block", setTimeout(function () {
            document.getElementById("unreadConversations").style.display = "none"
        }, 1e3)), Array.from(document.querySelectorAll(".message-list li.unread")).forEach(function (e) {
            e.classList.contains("unread") && e.classList.remove("unread");
            let inbox_mail_count = parseInt(document.querySelector(".inbox-mail-count").innerHTML);
            let c = e.querySelector(".mail-id").innerHTML, d = e.querySelector(".mail-readed").innerHTML;
            //let mail_starred = document.querySelector(".mail-starred").innerHTML;
            api.open("GET", url + "message/" + c + "/readed/" + (d === '1' ? '0' : '1'), !0);
            api.responseType = "json";
            api.onload = function () {
                const rep = api.status;
                console.log("status: " + rep);
                if (rep === 200) {
                    console.log("response: " + api.response);
                } else {

                }
            };
            api.send();
            document.querySelector(".inbox-mail-count").innerHTML = (inbox_mail_count - 1);
        })
    }), "build/images/users/user-dummy-img.jpg"), mailChatDetailElm = !1;


markAsUnreadBtn.addEventListener("click", function (e) {
    0 === document.querySelectorAll(".message-list li.unread").length && (document.getElementById("unreadConversations").style.display = "block", setTimeout(function () {
        document.getElementById("unreadConversations").style.display = "none"
    }, 1e3)), Array.from(document.querySelectorAll(".message-list li.unread")).forEach(function (e) {
        e.classList.contains("unread") && e.classList.remove("unread");
        let inbox_mail_count = parseInt(document.querySelector(".inbox-mail-count").innerHTML);
        let c = e.querySelector(".mail-id").innerHTML, d = e.querySelector(".mail-readed").innerHTML;
        //let mail_starred = document.querySelector(".mail-starred").innerHTML;
        api.open("GET", url + "message/" + c + "/readed/" + (d === '1' ? '0' : '1'), !0);
        api.responseType = "json";
        api.onload = function () {
            const rep = api.status;
            console.log("status: " + rep);
            if (rep === 200) {
                console.log("response: " + api.response);
            } else {

            }
        };
        api.send();
        document.querySelector(".inbox-mail-count").innerHTML = inbox_mail_count.toString();
    })
});

favouriteTBtn.addEventListener("click", function (e) {
    e.classList.contains("unread") && e.classList.remove("unread");
    let c = e.querySelector(".mail-id").innerHTML, d = e.querySelector(".mail-readed").innerHTML;
    api.open("GET", url + "message/" + c + "/readed/" + (d === '1' ? '0' : '1'), !0);
    api.responseType = "json";
    api.onload = function () {
        const rep = api.status;
        console.log("status: " + rep);
        if (rep === 200) {
            console.log("response: " + api.response);
        } else {

        }
    };
    api.send();
});

document.getElementById("refresh").addEventListener("click", function (e) {
    document.querySelector("#mail-list").innerHTML = "";
    loader.innerHTML = '<div id="elmLoader" class="text-center"><div class="spinner-border text-success avatar-sm" role="status"><span class="visually-hidden">Chargement...</span></div></div>';
    loadAllBoxes();
});

function emailDetailChange() {
    Array.from(document.querySelectorAll(".message-list li")).forEach(function (c) {
        c.addEventListener("click", function () {
            let e = c.querySelector(".checkbox-wrapper-mail .form-check-input").value;
            e = (document.querySelector(".remove-mail").setAttribute("data-remove-id", e), c.querySelector(".subject-title").innerHTML);
            const a = (document.querySelector(".email-subject-title").innerHTML = e, c.querySelector(".title-name").innerHTML);
            const t = (Array.from(document.querySelectorAll(".accordion-item.left")).forEach(function (e) {
                e.querySelector(".email-user-name").innerHTML = a;
                const t = c.querySelector(".mail-userimg").value;
                e.querySelector("img").setAttribute("src", t)
            }), document.querySelector(".user-name-text").innerHTML);
            const l = document.querySelector(".header-profile-user").getAttribute("src");
            Array.from(document.querySelectorAll(".accordion-item.right")).forEach(function (e) {
                e.querySelector(".email-user-name-right").innerHTML = t;
                e.querySelector("img").setAttribute("src", l);
            });
            document.querySelector(".email-text-body").innerHTML = c.querySelector(".html-body").innerHTML;
            document.querySelector(".email-user-name").innerHTML = c.querySelector(".title-name").innerHTML;
            document.querySelector(".mail-date").innerHTML = c.querySelector(".date .badge").innerHTML;

            let mail_id = c.querySelector(".mail-id").innerHTML;
            let mail_readed = c.querySelector(".mail-readed").innerHTML;
            //let mail_starred = document.querySelector(".mail-starred").innerHTML;

            api.open("GET", url + "message/" + mail_id + "/readed/" + (mail_readed === '1' ? '0' : '1'), !0);
            api.responseType = "json";
            api.onload = function () {
                const rep = api.status;
                console.log("status: " + rep);
                if (rep === 200) {
                    console.log("response: " + api.response);
                } else {

                }
            };
            api.send()
        })
    })
}

document.querySelectorAll(".email-chat-list a").forEach(function (l) {
    let e, t;
    l.classList.contains("active") && (/*document.getElementById("emailchat-detailElem").style.display = "block",*/ e = document.querySelector(".email-chat-list a.active").querySelector(".chatlist-user-name").innerHTML, t = document.querySelector(".email-chat-list a.active").querySelector(".chatlist-user-image img").getAttribute("src"), document.querySelector(".email-chat-detail .profile-username").innerHTML = e, document.getElementById("users-conversation").querySelectorAll(".left .chat-avatar").forEach(function (e) {
        t ? e.querySelector("img").setAttribute("src", t) : e.querySelector("img").setAttribute("src", dummyUserImage)
    })), l.addEventListener("click", function (e) {
        document.getElementById("emailchat-detailElem").style.display = "block", mailChatDetailElm = !0;
        var t = document.querySelector(".email-chat-list a.active"),
            t = (t && t.classList.remove("active"), this.classList.add("active"), scrollToBottom("users-chat"), l.querySelector(".chatlist-user-name").innerHTML),
            a = l.querySelector(".chatlist-user-image img").getAttribute("src"),
            t = (document.querySelector(".email-chat-detail .profile-username").innerHTML = t, document.getElementById("users-conversation"));
        Array.from(t.querySelectorAll(".left .chat-avatar")).forEach(function (e) {
            a ? e.querySelector("img").setAttribute("src", a) : e.querySelector("img").setAttribute("src", dummyUserImage)
        })
    })
}), document.getElementById("emailchat-btn-close").addEventListener("click", function () {
    document.getElementById("emailchat-detailElem").style.display = "none", mailChatDetailElm = !1, document.querySelector(".email-chat-list a.active").classList.remove("active")
});

triggerTabList.forEach(e => {
    const t = new bootstrap.Tab(e);
    e.addEventListener("click", e => {
        e.preventDefault();
        e = document.querySelector(".tab-content .tab-pane.show");
        console.log(e), t.show()
    })
});

getJSON("build/assets/json/mail-list.json", function (e, t) {
    if (e !== null) {
        console.log("Quelque chose s'est mal passé :" + e)
    } else {
        primaryMailList = t[0].primary;
        socialmaillist = t[0].social;
        promotionsmaillist = t[0].promotions;
        loadMailData(primaryMailList);
        loadSocialMailData(socialmaillist);
        loadPromotionsMailData(promotionsmaillist);
    }
});

Array.from(document.querySelectorAll(".mail-list a")).forEach(function (l) {
    l.addEventListener("click", function () {
        let t, e, a = document.querySelector(".mail-list a.active");
        a && a.classList.remove("active");
        l.classList.add("active");
        if (l.querySelector(".mail-list-link").hasAttribute("data-label")) {
            t = l.querySelector(".mail-list-link").getAttribute("data-label");
            e = primaryMailList.filter(e => e.labeltype === t);
            l.querySelector(".label-mail-count").innerHTML = e.length;
        } else {
            t = l.querySelector(".mail-list-link").getAttribute("data-type");
            document.getElementById("mail-list").innerHTML = "";

            e = primaryMailList.filter(e => e.tabtype === t);
            document.getElementById("mail-filter-navlist").style.display = "all" !== t && "inbox" !== t ? "none" : "block"
            l.querySelector("." + t + "-mail-count").innerHTML = e.length;
            console.log("." + t + "-mail-count");
        }
        loadMailData(e);
        favouriteBtn();
    })
});


