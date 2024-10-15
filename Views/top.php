<h2 style="text-align: center; margin: 20px 0;">TextSnippetSharing</h2>
<div id="editor-wrapper" style="display: flex; justify-content: center; margin-bottom: 20px;">
    <div id="editor-container" style="width:800px;height:600px;border:1px solid #ccc;"></div>
</div>
<h4 style="text-align: center; margin: 10px 0;">Optional Paste Settings</h4>
<div id="settings-wrapper" style="display: flex; flex-direction: column; margin: 0 auto; align-items: center; width: 200px; width: 250px;">
    <span style="margin-bottom: 10px;">Syntax Highlight</span>
    <select name="language" id="language" class="form-select" style="margin-bottom: 10px;"></select>
    <span style="margin-bottom: 10px;">Paste Expiration</span>
    <select name="expiration-date" id="expiration-date" class="form-select" style="margin-bottom: 20px;">
        <option value="10minutes">10 Minutes</option>
        <option value="1hour">1 Hour</option>
        <option value="1day">1 Day</option>
        <option value="1week">1 week</option>
        <option value="2weeks">2 weeks</option>
        <option value="1month">1 month</option>
        <option value="6months">6 months</option>
        <option value="1year">1 year</option>
    </select>
    <button type="button" class="btn btn-primary" style="margin-bottom: 20px;" onclick="submitForm()">Create Snippet</button>
</div>

<!-- 隠しフォーム -->
<form id="editorForm" method="POST" action="/share">
    <input type="hidden" name="snippet" id="hiddenSnippet">
    <input type="hidden" name="language" id="hiddenLanguage">
    <input type="hidden" name="expirationDate" id="hiddenExpirationDate">
</form>

<script>
    require.config({
        paths: {
            'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.33.0/min/vs'
        }
    });
    require(['vs/editor/editor.main'], function() {
        editor = monaco.editor.create(document.getElementById('editor-container'), {
            value: '',
            language: 'javascript'
        });

        const languages = monaco.languages.getLanguages();

        // セレクトボックス要素を取得
        let languageSelect = document.getElementById('language');

        // 言語リストから選択肢を動的に生成
        languages.forEach(function(language) {
            let option = document.createElement('option');
            option.value = language.id;
            option.textContent = language.id;
            languageSelect.appendChild(option);
        });

        // 初期値としてjavascriptを選択
        languageSelect.value = 'javascript';

        // セレクトボックスの変更を監視して言語を変更
        languageSelect.addEventListener('change', function() {
            let selectedLanguage = languageSelect.value;
            monaco.editor.setModelLanguage(editor.getModel(), selectedLanguage);
        });
    });

    function submitForm() {
        // Monaco Editorの内容を取得
        const editorContent = editor.getValue();
        const language = document.getElementById('language').value;
        const expirationDate = document.getElementById('expiration-date').value;

        // hiddenInputに値を設定
        document.getElementById('hiddenSnippet').value = editorContent;
        document.getElementById('hiddenLanguage').value = language;
        document.getElementById('hiddenExpirationDate').value = expirationDate;

        // フォームを送信
        const form = document.getElementById('editorForm');
        form.submit();
    }
</script>

</body>

</html>