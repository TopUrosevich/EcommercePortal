<div class="form-group">
    <div class="quill-wrapper">
        <div id="toolbar" class="toolbar ql-toolbar ql-snow">
            <span class="ql-format-group">
                <select title="Font" class="ql-font">
                    <option value="sans-serif" selected="">Sans Serif</option>
                    <option value="serif">Serif</option>
                    <option value="monospace">Monospace</option>
                </select>
                <select title="Size" class="ql-size">
                    <option value="10px">Small</option>
                    <option value="13px" selected="">Normal</option>
                    <option value="18px">Large</option>
                    <option value="32px">Huge</option>
                </select>
            </span>
            <span class="ql-format-group">
                <span title="Bold" class="ql-format-button ql-bold"></span>
                <span class="ql-format-separator"></span>
                <span title="Italic" class="ql-format-button ql-italic"></span>
                <span class="ql-format-separator"></span>
                <span title="Underline" class="ql-format-button ql-underline"></span>
                <span class="ql-format-separator"></span>
                <span title="Strikethrough" class="ql-format-button ql-strike"></span>
            </span>
            <span class="ql-format-group">
                <span title="List" class="ql-format-button ql-list"></span>
                <span class="ql-format-separator"></span>
                <span title="Bullet" class="ql-format-button ql-bullet"></span>
                <span class="ql-format-separator"></span>
                <select title="Text Alignment" class="ql-align">
                    <option value="left" label="Left" selected=""></option>
                    <option value="center" label="Center"></option>
                    <option value="right" label="Right"></option>
                    <option value="justify" label="Justify"></option>
                </select>
            </span>
            <span class="ql-format-group">
                <span title="Link" class="ql-format-button ql-link"></span>
                <span class="ql-format-separator"></span>
                <span title="Image" class="ql-format-button ql-image ql-active"></span>
            </span>
        </div>
        <div id="editor" class="editor ql-container ql-snow focus">
        </div>
    </div>
    <span class="text-danger">
        {{ form.hasMessagesFor('content') ? form.getMessagesFor('content')[0] : '' }}
    </span>
</div>