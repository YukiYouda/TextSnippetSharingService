<h2 style="text-align: center; margin: 20px 0;">TextSnippetSharing</h2>
<div id="editor-wrapper" style="display: flex; justify-content: center; margin-bottom: 20px;">
    <div id="editor-container" style="width:800px;height:600px;border:1px solid #ccc;"></div>
</div>

<script>
    require.config({
        paths: {
            'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.33.0/min/vs'
        }
    });
    require(['vs/editor/editor.main'], function() {
        editor = monaco.editor.create(document.getElementById('editor-container'), {
            value: <?php echo json_encode($snippet['snippet']); ?>,
            language: <?php echo json_encode($snippet['programing_language']); ?>,
            readOnly: true
        });
    });
</script>
</body>
</html>