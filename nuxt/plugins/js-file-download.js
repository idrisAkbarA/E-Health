export default (context, inject) => {
    var fileDownload = require('js-file-download');
    // fileDownload(data, 'filename.csv');
    inject('download', fileDownload)

}