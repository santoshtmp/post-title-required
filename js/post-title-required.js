jQuery(function ($) {
    // Set your desired character limit
    try {
        var characterLimit = data_obj.postCharacterLimit;
    } catch (error) {
        var characterLimit = 100;
    }

    /**
     * check post title 
     */
    let titleField = $('input[name="post_title"]');
    if (titleField.length) {
        // For the post without editor
        post_input_title_field(titleField);
    } else {
        // For the post with editor
        post_input_title_editor();
    }

    /**
     * 
     * @param {*} titleField 
     */
    function post_input_title_field(titleField) {
        titleField.prop('required', true);
        titleField.on('input', function () {
            var currentLength = titleField.val().length;
            if (currentLength > characterLimit) {
                var trimmedTitle = titleField.val().substring(0, characterLimit);// Trim the title to the character limit
                titleField.val(trimmedTitle);
                $('#title_limit_warning').remove();
                $('#titlewrap').append(
                    '<div id="title_limit_warning" class="notice notice-warning is-dismissible"><p>Title character limit is ' +
                    characterLimit +
                    '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
                );
                $('#title_limit_warning button').on('click', function () {
                    $('#title_limit_warning').remove();
                });
            }
        });
    }

    /**
     * for the post support editor
     */
    function post_input_title_editor() {
        let check_save_btn = setInterval(function () {
            let save_btn = $('.editor-header__settings button.editor-post-publish-button__button ');
            if (save_btn.length) {
                clearInterval(check_save_btn);
                post_editor_submit(save_btn);
                check_editor_title_on_input();
            }
        }, 1000);


    }


    /***
     * event when publich or update btn is click on post editor
     */
    function post_editor_submit(save_btn) {
        save_btn.on('click', function (e) {
            let title = $('.editor-visual-editor__post-title-wrapper h1').text();
            let currentLength = title.length;
            if (title.trim() === '') {
                let title_null_notice = editor_warning_notice('Title is empty. Plese fill it out.');
                $('.wp-title-check-required').remove();
                $('.interface-navigable-region .components-notice-list.components-editor-notices__dismissible').append(title_null_notice);
                document.querySelector('.wp-title-check-required').scrollIntoView();
                e.stopPropagation();
                e.preventDefault();
                return false;
            } else if (currentLength > characterLimit) {
                let title_limit_notice = editor_warning_notice('Title character limit is ' + characterLimit);
                $('.wp-title-check-required').remove();
                $('.interface-navigable-region .components-notice-list.components-editor-notices__dismissible').append(title_limit_notice);
                document.querySelector('.wp-title-check-required').scrollIntoView();
                e.stopPropagation();
                e.preventDefault();
                $(window).scrollTop(0);
                return false;
            } else {
                $('.wp-title-check-required').remove();
            }
            $('.wp-title-check-required button').on('click', function () {
                $('.wp-title-check-required').remove();
            });
        });
    }

    /**
     * check_editor_title_on_input
     */
    function check_editor_title_on_input() {
        $('.editor-visual-editor__post-title-wrapper h1').on('input', function () {
            let title = $('.editor-visual-editor__post-title-wrapper h1').text();
            let currentLength = title.length;
            if (currentLength > characterLimit) {
                // let trimmedTitle = title.substring(0, characterLimit);
                // $('.editor-visual-editor__post-title-wrapper h1').text(trimmedTitle);
                let title_limit_notice = editor_warning_notice('Title character limit is ' + characterLimit);
                $('.wp-title-check-required').remove();
                $('.interface-navigable-region .components-notice-list.components-editor-notices__dismissible').append(title_limit_notice);
            } else {
                $('.wp-title-check-required').remove();
            }
        });
    }

    /**
     * 
     * @param {*} text 
     * @returns 
     */
    function editor_warning_notice(text) {
        let notice = '<div class="components-notice is-warning is-dismissible wp-title-check-required"><div class="components-notice__content">' + text + '</div><button type="button" class="components-button components-notice__dismiss has-icon" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"></path></svg></button></div>';
        return notice;
    }

    /**
     * quick edit field
     */
    $('.row-actions button.editinline').on('click', function () {
        var titleField = $('input[name="post_title"]');
        titleField.prop('required', true);
        titleField.parent().parent().addClass('title-required');
        $('.requird-identify').remove();
        $('.title-required .title').append('<span class="requird-identify" style="color: #f00;">*</span>');
        setTimeout(function () {
            if (titleField.val().length === 0) {
                $('.submit button.save').prop('disabled', true);
            }
        }, 1000);

        titleField.on('input', function () {
            titleField = $('input[name="post_title"]');
            var currentLength = titleField.val().length;
            if (currentLength === 0) {
                $('.submit button.save').prop('disabled', true);
                $('.wp-title-check-required').remove();
                $('.title-required .input-text-wrap').append('<span class="wp-title-check-required" style="color: #f00;"> Title is required </span>');
            } else if (currentLength > characterLimit) {
                var trimmedTitle = titleField.val().substring(0, characterLimit);
                titleField.val(trimmedTitle);
                $('.submit button.save').prop('disabled', true);
                $('.wp-title-check-required').remove();
                $('.title-required .input-text-wrap').append('<span class="wp-title-check-required" style="color: #f00;"> Title character limit is ' + characterLimit + '</span>');
            } else {
                $('.submit button.save').prop('disabled', false);
                $('.wp-title-check-required').remove();
            }
        });
    });

    /**
     * END
     */
});
