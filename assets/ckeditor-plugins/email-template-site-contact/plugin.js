/* globals CKEDITOR */
'use strict';

(function () {
    const PLACEHOLDERS = [
        {
            id: 'NAME',
            name: 'NAME',
            title: 'NAME',
            description: 'It will be replaced with a name.',
        },
        {
            id: 'EMAIL',
            name: 'EMAIL',
            title: 'EMAIL',
            description: 'It will be replaced with an email.',
        },
        {
            id: 'MESSAGE',
            name: 'MESSAGE',
            title: 'MESSAGE',
            description: 'It will be replaced with a message.',
        },
    ];

    CKEDITOR.plugins.add('email-template-site-contact', {
        requires: 'autocomplete,textmatch,placeholder',
        init: function (editor) {

            const itemTemplate = '' +
                '<li data-id="{id}">' +
                '<div><strong class="item-title">{title}</strong></div>' +
                '<div><i>{description}</i></div>' +
                '</li>';

            const outputTemplate = '[[{id}]]';

            let autocomplete = new CKEDITOR.plugins.autocomplete(editor, {
                textTestCallback: textTestCallback,
                dataCallback: dataCallback,
                itemTemplate: itemTemplate,
                outputTemplate: outputTemplate,
            });

            // Override default getHtmlToInsert to enable rich content output.
            autocomplete.getHtmlToInsert = function (item) {
                return this.outputTemplate.output(item);
            };
        },
    });

    function textTestCallback(range) {
        if (!range.collapsed) {
            return null;
        }

        return CKEDITOR.plugins.textMatch.match(range, matchCallback);
    }

    function matchCallback(text, offset) {
        let pattern = /\[{2}([A-z]|\])*$/,
            match = text.slice(0, offset)
                .match(pattern);

        if (!match) {
            return null;
        }

        return {
            start: match.index,
            end: offset,
        };
    }

    function dataCallback(matchInfo, callback) {
        let data = PLACEHOLDERS.filter(function (item) {
            let itemName = '[[' + item.name +  ']]';
            return itemName.indexOf(matchInfo.query.toLowerCase()) === 0;
        });

        callback(data);
    }

})();
