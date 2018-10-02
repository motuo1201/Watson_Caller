    /* エラー文字列の生成 */
    function ajaxErrorHandler(args) {
        var error;
        // errorThrownはHTTP通信に成功したときだけ空文字列以外の値が定義される
        if (args[2]) {
            try {
                // JSONとしてパースが成功し、且つ {"error":"..."} という構造であったとき
                // (undefinedが代入されるのを防ぐためにtoStringメソッドを使用)
                error = $.parseJSON(args[0].responseText).error.toString();
            } catch (e) {
                // パースに失敗した、もしくは期待する構造でなかったとき
                // (PHP側にエラーがあったときにもデバッグしやすいようにレスポンスをテキストとして返す)
                error = 'parsererror(' + args[2] + '): ' + args[0].responseText;
            }
        } else {
            // 通信に失敗したとき
            error = args[1] + '(HTTP request failed)';
        }
        return error;
    }