<style>
.PR0 a {
    text-decoration: none;
}
.ui-menu .ui-menu-item:hover {
    background: #e40046;
    color: white;
    cursor: pointer;
}
.ui-menu .ui-menu-item{padding:10px; font-size:1.2em!important;}
.ui-menu.ui-widget.ui-widget-content.ui-autocomplete.ui-front{z-index: 1000}
.progress-bar-animated {
    -webkit-animation: progress-bar-stripes 1s linear infinite;
    -o-animation: progress-bar-stripes 1s linear infinite;
    animation: progress-bar-stripes 1s linear infinite;
}
.animated {
    -webkit-animation-duration: .3s;
    animation-duration: .3s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}
@keyframes zoomIn {
    0% {
        opacity: 0;
        -webkit-transform: scale(.3);
        -ms-transform: scale(.3);
        transform: scale(.3);
    }

    50% {
        opacity: 1;
    }
}

.zoomIn {
    -webkit-animation-name: zoomIn;
    animation-name: zoomIn;
}
#web_notify{ width: 400px; height: 100px; bottom: 20px; position: fixed; right: 20px; }
#web_notify.bottom_show {
    bottom: 20px;
    transition-property: all;
    transition-duration: 1s;
    transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}
#web_notify.bottom_hide {
    bottom: -400px;
    transition-property: all;
    transition-duration: 1s;
    transition-timing-function: cubic-bezier(0, 1,3, 1);
}
#web_notify.left_show {
    right: 20px;

    transition-property: all;
    transition-duration: 1s;
    transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}
#web_notify.left_hide {
    right: -600px;
    transition-property: all;
    transition-duration: 1s;
    transition-timing-function: cubic-bezier(0, 1,3, 1);
}
.notify_image {
    border-radius: 10px;
    border: thin solid #ccc;
    height: 100px;
    text-align: center;
    overflow: hidden;
}
.notify_image img{ width: auto; height: 90px; margin-top: 2px; }
.notify_content {
    border: thin solid #ccc;
    padding: 10px;
    height: 100px;
    border-radius: 10px;
    display: table-cell; vertical-align: middle;
    box-shadow: inset 0 0 20px #999, 0px 0px 60px #111 !important;
}
.notify_box{ box-shadow: 0px 0px 60px #111; background: #fff;  }
.close_button{  position: absolute;
    top: -8px;
    right: -7px;
    width: 20px;
    height: 20px;
    border: thin solid #123;
    padding: 0px 5px;
    border-radius: 15px;
    background: #ccc;
    box-shadow: 1px 1px 4px #000;
    cursor: pointer;
    font-size: 13px;  }
.close_button:hover{ box-shadow: 1px 1px 10px #000;  }
.progress {
    display: block;
    height: 2px;
    background: #000;
    width: 100%;
    margin-top: 5px;
}
.content_box a{ color: #e40046 }
.content_box a strong{ font-style: italic; font-weight: bolder;}
</style>