(function ($) {
    'use strict';

    if (typeof acf === 'undefined' || typeof luminaIcons === 'undefined') {
        return;
    }

    function iconChoiceMarkup(state) {
        if (!state.id) {
            return state.text;
        }

        var icon = luminaIcons[state.id];

        if (!icon || !icon.url) {
            return state.text;
        }

        return (
            '<span class="lumina-icon-choice">' +
            '<img src="' + icon.url + '" alt="" />' +
            '<span>' + (icon.label || state.text) + '</span>' +
            '</span>'
        );
    }

    acf.addFilter('select2_args', function (args, $select, settings, field) {
        if (!field || field.get('name') !== 'icon_lumina') {
            return args;
        }

        args.templateResult = iconChoiceMarkup;
        args.templateSelection = iconChoiceMarkup;
        args.escapeMarkup = function (markup) {
            return markup;
        };

        return args;
    });

    function updatePreview($field) {
        var $preview = $field.find('[data-lumina-icon-preview]');
        var value = $field.find('select').val();
        var icon = value ? luminaIcons[value] : null;

        if (!$preview.length) {
            return;
        }

        if (!icon || !icon.url) {
            $preview.html(
                '<span class="lumina-icon-preview__empty">Aucune icône sélectionnée</span>'
            );
            return;
        }

        $preview.html(
            '<img src="' + icon.url + '" alt="' + (icon.label || '') + '" width="40" height="40" />' +
            '<span class="lumina-icon-preview__label">' + (icon.label || value) + '</span>'
        );
    }

    acf.addAction('render_field/name=icon_lumina', function (field) {
        updatePreview(field.$el);

        field.$el.find('select').on('change', function () {
            updatePreview(field.$el);
        });
    });
})(jQuery);
