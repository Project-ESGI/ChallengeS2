// $.showAlert = function (opts, close, limit) {
//     opts = $.extend(true, {
//         type: 'green',
//         title: 'Message',
//         message: '',
//         okButton: 'Ok',
//         limit: limit || 2000
//     }, opts || {});
//
//     let closeIcon = false;
//     if (opts.type === 'green') {
//         closeIcon = true;
//         if (close) {
//             opts.autoClose = 'cancel|' + opts.limit;
//         }
//     }
//     $.alert({
//         bgOpacity: 0.9,
//         theme: 'supervan',
//         type: opts.type,
//         icon: 'fa fa-question-circle',
//         title: opts.title,
//         content: opts.message,
//         closeIcon: closeIcon,
//         autoClose: opts.autoClose,
//         buttons: {
//             cancel: {
//                 text: opts.okButton,
//                 keys: ['esc', 'enter']
//             }
//         }
//     });
// };