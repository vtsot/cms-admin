/* globals CKEDITOR */

const DEFAULT_LOCALE = 'en_GB';

/** @var Object : {} as {[cmsEmbedKey: string] : cmsEmbed[]} */
const CMS_EMBEDS = {};

CKEDITOR.plugins.add('cms-embed', {
    requires: 'richcombo',

    init: function (editor) {
        'use strict';

        const locale = getLocale(editor);
        const cmsEmbedKey = getCmsEmbedKey(editor);

        CMS_EMBEDS[cmsEmbedKey] = [];

        // resolve siteId from url e.g. https://example.com/site/01a16459-7d94-7436-bef8-491f292baedf/param-1/value-1
        const match = window.location.pathname.match(/\/site\/([^/]+)/);
        const siteId = match?.[1] ?? null;
        const cmsEmbedUrl = document.documentElement.dataset.apiCmsEmbedCollectionUrl + (siteId ? '?site=' + siteId : '');

        // load cms-embeds
        const xhr = new XMLHttpRequest();
        xhr.open('GET', cmsEmbedUrl);
        xhr.setRequestHeader('accept', 'application/json');
        xhr.setRequestHeader('Accept-Language', locale);
        xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token') );
        // xhr.addEventListener('loaded', editor.setMode('wysiwyg'));
        xhr.send();

        // cms-embeds loaded
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const json = JSON.parse(xhr.responseText);
                json.items.forEach((cmsEmbed) => {
                    CMS_EMBEDS[cmsEmbedKey].push(cmsEmbed);
                });

                initCmsEmbedsDialog(editor, CMS_EMBEDS[cmsEmbedKey], cmsEmbedKey);
                initCmsEmbedsRichCombo(editor, CMS_EMBEDS[cmsEmbedKey], cmsEmbedKey);

                editor.setMode('wysiwyg');
            }
        };

        initCmsEmbedsRichCombo(editor, CMS_EMBEDS[cmsEmbedKey], cmsEmbedKey);
    },
});

/**
 * @param {Object} editor
 * @param {Array} cmsEmbeds
 * @param {String} cmsEmbedKey
 */
const initCmsEmbedsRichCombo = (editor, cmsEmbeds, cmsEmbedKey) => {
    editor.ui.addRichCombo('CmsEmbed', {
        label: 'Embed',
        title: 'Embed Content',
        toolbar: 'basicstyles,0',

        panel: {
            css: [CKEDITOR.skin.getPath('editor')].concat(editor.config.contentsCss),
            multiSelect: false,
            attributes: {'aria-label': 'Embed Content'},
        },

        init: function () {
            this.startGroup('Embed Contents');

            cmsEmbeds.forEach((cmsEmbed) => {
                let richComboKey = cmsEmbed.id + '-' + cmsEmbedKey;
                this.add(richComboKey, cmsEmbed.label);
            });
        },

        onClick: function (cmsEmbedKey) {
            editor.execCommand(cmsEmbedKey);
        },
    });
};


/**
 * @param {Object} editor
 */
const getLocale = (editor) => {
    let name = editor.element.$.name.replaceAll('[', '-').replaceAll(']', '-').replaceAll('--', '-').slice(0, -1);

    let nameParts = name.split('-').reverse();

    if (typeof (nameParts[1]) === 'undefined') {
        console.error('Unable to resolve locale from the editor name.', editor.element.$.name);
    }

    return typeof (nameParts[1]) !== 'undefined'
        ? nameParts[1]
        : DEFAULT_LOCALE;
};

/**
 * @param {Object} editor
 */
const getCmsEmbedKey = (editor) => {
    return editor.element.$.name.replaceAll('[', '-').replaceAll(']', '-').replaceAll('--', '-').slice(0, -1);
};


/**
 * @param {Object} editor
 * @param {Array} cmsEmbeds
 * @param {String} cmsEmbedKey
 */
const initCmsEmbedsDialog = (editor, cmsEmbeds, cmsEmbedKey) => {
    'use strict';

    cmsEmbeds.forEach((cmsEmbed) => {
        let dialogName = '';

        // open dialog
        // eslint-disable-next-line no-prototype-builtins
        if (cmsEmbed.hasOwnProperty('params') &&
            Array.isArray(cmsEmbed.params) &&
            cmsEmbed.params.length > 0
        ) {
            dialogName = newDialog(cmsEmbed, cmsEmbedKey);
        }

        let widgetKey = cmsEmbed.id + '-' + cmsEmbedKey;
        editor.widgets.add(widgetKey, {
            template: cmsEmbed.placeholder,
            dialog: dialogName,
            upcast(element) {
                return element.name === 'div' && element.hasClass(cmsEmbed.id);
            },
        });
    });
};

/**
 * @param {Object} cmsEmbed
 * @param {String} cmsEmbedKey
 * @param {Number|undefined} minWidth
 * @param {Number|undefined} minHeight
 * @see https://ckeditor.com/docs/ckeditor4/latest/guide/dev_howtos_dialog_windows.html
 * @see https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_dialog_definition.html
 */
const newDialog = (cmsEmbed, cmsEmbedKey, minWidth, minHeight) => {
    'use strict';

    let params = cmsEmbed.params,
        dialogName = cmsEmbed.id + '-' + cmsEmbedKey;

    // count how many params has marked as replace_help
    let replaceHelpParamsCounter = 0;
    params.forEach(function (param) {
        // eslint-disable-next-line no-prototype-builtins
        if (param.hasOwnProperty('replace_help') &&
            param.replace_help === true
        ) {
            replaceHelpParamsCounter = replaceHelpParamsCounter + 1;
        }
    });

    params.forEach(function (param, i, params) {
        let paramId = param.id;

        // set handler setup
        params[i].setup = function (cmsEmbed) {
            let paramValue = cmsEmbed.element.getAttribute('data-' + paramId);

            // resolve checkbox is checked
            if (param.type === 'checkbox') {
                let isChecked = false;
                // eslint-disable-next-line no-prototype-builtins
                if (paramValue === null && param.hasOwnProperty('default')) {
                    isChecked = !!param.default;
                }

                if (paramValue === 'true') {
                    isChecked = true;
                }

                this.setValue(isChecked);

                return;
            }

            // set pram value
            if (paramValue) {
                this.setValue(paramValue);
            }
        };

        // eslint-disable-next-line no-prototype-builtins
        if (param.hasOwnProperty('mask') && param.hasOwnProperty('map')) {

            // set handler hideMaskElements
            params[i].hideMaskElements = function () {
                for (const [key, entries] of Object.entries(this.map)) {
                    entries.forEach((elementId) => {
                        handleDisplayMaskElement(elementId, 'none');
                    });
                }
            };

            // set handler showMaskElements
            params[i].showMaskElements = function (maskId) {
                // eslint-disable-next-line no-prototype-builtins
                if (this.map.hasOwnProperty(maskId)) {
                    const map = this.map[maskId];
                    map.forEach((elementId) => {
                        handleDisplayMaskElement(elementId, '');
                    });
                }
            };

            // set handler onChange
            params[i].onChange = function () {
                const maskId = this.getValue();

                // hide hideMaskElements before show depended elements
                params[i].hideMaskElements();

                // show depends elements
                // eslint-disable-next-line no-prototype-builtins
                if (param.map.hasOwnProperty(maskId)) {
                    params[i].showMaskElements(maskId);
                }
            };
        }

        // set handler commit
        params[i].commit = function (cmsEmbed) {
            // // change placeholder image depends on selected value
            // if (typeof (this.placeholderImages) !== 'undefined' &&
            //     typeof (this.placeholderImages[this.getValue()]) === 'string' &&
            //     this.placeholderImages[this.getValue()].length > 0
            // ) {
            //     let imgUrl = this.placeholderImages[this.getValue()];
            //     cmsEmbed.element.setHtml('<img src="' + imgUrl + '">');
            // }

            // set cmsEmbed attributes
            cmsEmbed.element.setAttribute('data-' + paramId, this.getValue());

            // set cmsEmbed help from param value
            // eslint-disable-next-line no-prototype-builtins
            if (this.hasOwnProperty('replace_help') &&
                this.replace_help === true &&
                this.type !== 'checkbox' // skip all checkboxes
            ) {
                let cmsEmbedHelp = null;

                // resolve help text from drop-down options
                // eslint-disable-next-line no-prototype-builtins
                if (this.hasOwnProperty('items') &&
                    (this.type === 'select' || this.type === 'radio')
                ) {
                    this.items.forEach((item) => {
                        let label = typeof (item[0]) !== 'undefined' ? item[0] : null;
                        let value = typeof (item[1]) !== 'undefined' ? item[1] : null;
                        if (value !== null && value === this.getValue()) {
                            cmsEmbedHelp = label;
                        }
                    });
                }

                // resolve help text from checkbox
                // eslint-disable-next-line no-prototype-builtins
                if (this.hasOwnProperty('label') &&
                    this.type === 'checkbox' &&
                    this.getValue() === true
                ) {
                    cmsEmbedHelp = this.label;
                }

                // resolve default help
                if (cmsEmbedHelp === null) {
                    cmsEmbedHelp = this.getValue();
                }

                // set help
                if (cmsEmbedHelp !== null) {
                    /** @var {HTMLCollection} children */
                    let children = cmsEmbed.element.$.children;
                    for (let i = 0; i < children.length; i++) {
                        let helpArea = children.item(i);
                        if (helpArea !== null &&
                            helpArea.classList.contains('cms-embed-help')
                        ) {
                            let paramHelp = null;
                            for (let y = 0; y < helpArea.children.length; y++) {
                                if (helpArea.children.item(y).dataset.helpParamId === this.id) {
                                    paramHelp = helpArea.children.item(y);
                                }
                            }

                            if (paramHelp === null) {
                                paramHelp = document.createElement('div');
                                paramHelp.dataset.helpParamId = this.id;
                                paramHelp.innerHTML = '';
                                helpArea.appendChild(paramHelp);
                            }

                            paramHelp.innerHTML = this.label + ': ' + cmsEmbedHelp;
                        }
                    }
                }
            }

            /** @var {Element|null} visibilityElement */
            let visibilityElement = null;
            let visibilityFound = false;
            /** @var {HTMLCollection} children */
            let children = cmsEmbed.element.$.children;
            for (let i = 0; i < children.length; i++) {
                if (children.item(i) !== null &&
                    children.item(i).classList.contains('cms-embed-visibility')
                ) {
                    visibilityFound = true;
                    visibilityElement = children.item(i);
                    if (visibilityElement.children.length === 0) {
                        visibilityElement.innerHTML = '';
                    }
                }
            }

            if (visibilityFound === false) {
                let visibilityElement = document.createElement('div');
                visibilityElement.innerHTML = '';
                visibilityElement.classList.add('cms-embed-visibility');
                cmsEmbed.element.$.appendChild(visibilityElement);
            }

            // set cmsEmbed visibility for user from param value
            // @see CmsEmbedInterface::VISIBILITY_PARAM_ID
            if (this.id === 'visibility') {
                let visibilityLabel = null;

                // resolve help text from drop-down options
                if (this.type === 'select' &&
                    // eslint-disable-next-line no-prototype-builtins
                    this.hasOwnProperty('items')
                ) {
                    this.items.forEach((item) => {
                        let label = typeof (item[0]) !== 'undefined' ? item[0] : null;
                        let value = typeof (item[1]) !== 'undefined' ? item[1] : null;
                        if (value !== null && value === this.getValue()) {
                            visibilityLabel = label;
                        }
                    });

                    // resolve default visibility
                    if (visibilityLabel === null) {
                        visibilityLabel = this.getValue();
                    }

                    if (visibilityLabel !== null) {
                        /** @var {HTMLCollection} children */
                        let children = visibilityElement.children;

                        for (let i = 0; i < children.length; i++) {
                            let visibilityUser = children.item(i);
                            if (visibilityUser !== null &&
                                visibilityUser.classList.contains('cms-embed-visibility-user')
                            ) {
                                visibilityElement.removeChild(visibilityUser);
                            }
                        }

                        let visibilityUser = document.createElement('div');
                        visibilityUser.innerHTML = visibilityLabel;
                        visibilityUser.classList.add('cms-embed-visibility-user');
                        visibilityElement.appendChild(visibilityUser);
                    }
                }
            }

            // set cmsEmbed visibility for campaign from param value
            // @see CmsEmbedInterface::CAMPAIGN_PARAM_ID
            if (this.id === 'campaign') {
                let campaignLabel = null;

                // resolve help text from drop-down options
                if (this.type === 'select' &&
                    // eslint-disable-next-line no-prototype-builtins
                    this.hasOwnProperty('items')
                ) {
                    this.items.forEach((item) => {
                        let label = typeof (item[0]) !== 'undefined' ? item[0] : null;
                        let value = typeof (item[1]) !== 'undefined' ? item[1] : null;
                        if (value !== null && value === this.getValue()) {
                            campaignLabel = label;
                        }
                    });

                    // resolve default campaign
                    if (campaignLabel === null) {
                        campaignLabel = this.getValue();
                    }

                    if (campaignLabel !== null) {
                        /** @var {HTMLCollection} children */
                        let children = visibilityElement.children;

                        for (let i = 0; i < children.length; i++) {
                            let visibilityCampaign = children.item(i);
                            if (visibilityCampaign !== null &&
                                visibilityCampaign.classList.contains('cms-embed-visibility-campaign')
                            ) {
                                visibilityElement.removeChild(visibilityCampaign);
                            }
                        }

                        let visibilityCampaign = document.createElement('div');
                        visibilityCampaign.innerHTML = campaignLabel;
                        visibilityCampaign.classList.add('cms-embed-visibility-campaign');
                        visibilityElement.appendChild(visibilityCampaign);
                    }
                }
            }

            // add campaign-value as comment
            // @see CmsEmbedInterface::CAMPAIGN_VALUE
            if (this.id === 'campaign-value' &&
                Number(cmsEmbed.element.getAttribute('data-campaign')) === 1
            ) {
                let children = visibilityElement.children;
                for (let i = 0; i < children.length; i++) {
                    let visibilityCampaign = children.item(i);
                    if (visibilityCampaign !== null &&
                        visibilityCampaign.classList.contains('cms-embed-visibility-campaign')
                    ) {
                        // visible only for expected campaigns
                        if (this.getValue().length > 0) {
                            visibilityCampaign.innerHTML = visibilityCampaign.innerHTML + ': ' + this.getValue();
                        } else {
                            // visible only for any campaign
                            visibilityCampaign.innerHTML = 'Visible for any campaign';
                        }
                    }
                }
            }
        };
    });

    // resolve dialog width
    if (typeof (minWidth) === 'undefined') {
        minWidth = 400;
    }

    // resolve dialog height
    if (typeof (minHeight) === 'undefined') {
        minHeight = 200;
    }

    // add dialog
    CKEDITOR.dialog.add(dialogName, (editor) => {
        return {
            title: cmsEmbed.label + ' Settings',
            minWidth: minWidth,
            minHeight: minHeight,
            contents: [
                {
                    id: 'tab-basic',
                    label: 'Basic Settings',
                    elements: params,
                },
            ],
            onShow: () => {
                params.forEach((param) => {
                    // eslint-disable-next-line no-prototype-builtins
                    if (param.hasOwnProperty('mask') && param.hasOwnProperty('map')) {
                        // hide depended items
                        for (const [key, entries] of Object.entries(param.map)) {
                            entries.forEach((elementId) => {
                                handleDisplayMaskElement(elementId, 'none');
                            });
                        }
                    }
                });
            },
        };
    });

    return dialogName;
};

/**
 * @param {String} elementId
 * @param {string} display
 */
const handleDisplayMaskElement = (elementId, display) => {
    const element = document.querySelector('.cke_dialog .' + elementId);
    if (element === null) {
        return;
    }

    const parentTr = element.closest('tr');
    if (parentTr === null) {
        return;
    }

    parentTr.style.display = display;
};

const getMethods = (obj) => {
    let properties = new Set();
    let currentObj = obj;
    do {
        Object.getOwnPropertyNames(currentObj).map(item => properties.add(item));
    } while ((currentObj = Object.getPrototypeOf(currentObj)));
    return [...properties.keys()].filter(item => typeof obj[item] === 'function');
};
