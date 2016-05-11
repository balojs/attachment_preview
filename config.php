<?php
require_once INCLUDE_DIR . 'class.plugin.php';

class AttachmentPreviewPluginConfig extends PluginConfig
{
    // Provide compatibility function for versions of osTicket prior to
    // translation support (v1.9.4)
    function translate()
    {
        if (! method_exists('Plugin', 'translate')) {
            return array(
                function ($x) {
                    return $x;
                },
                function ($x, $y, $n) {
                    return $n != 1 ? $y : $x;
                }
            );
        }
        return Plugin::translate('pdf_preview');
    }

    /**
     * Build an Admin settings page.
     * {@inheritDoc}
     * @see PluginConfig::getOptions()
     */
    function getOptions()
    {
        list ($__, $_N) = self::translate();
        return array(
            'attachment' => new SectionBreakField(array(
                'label' => $__('Attachment Inliner')
            )),

            'attachment-video' => new BooleanField(array(
                'label' => $__('Convert Youtube to Player'),
                'hint' => $__("Sick of clicking links and opening videos in new windows? Watch them in the thread!")
            )),

            'attachment-allowed' => new ChoiceField(array(
                'label' => $__('Choose the types of attachments to inline.'),
                'default' => 'pdf-image',
                'hint' => $__("While HTML and Text documents are filtered before being inserted in the DOM, there is always a chance this is riskier than necessary, Has no effect if txt & html extensions are not allowed to be attached in the first place."),
                'choices' => array(
                    'none' => $__('Safest: OFF'),
                    'pdf' => $__('PDF Only'),
                    'image' => $__('Images Only'),
                    'pdf-image' => $__('PDF\'s and Images'),
                    'all' => $__('I accept the risk: ALL')
                )
            )),

            'attachment-enabled' => new ChoiceField(array(
                'label' => $__('Permission'),
                'default' => "staff",
                'hint' => 'Who needs access to these embedded fields?',
                'choices' => array(
                    'disabled' => $__('Disabled'),
                    'staff' => $__('Agents Only'),
                    'all' => $__('Agents & Customers')
                )
            ))
        );
    }
}