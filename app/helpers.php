<?php

use Illuminate\Support\HtmlString;

/**
 * @return HtmlString
 */
function loadCurrentLocaleTranslations(): HtmlString
{
    $languageScript = '';

     try {
        $translations = json_encode( __('*'));
       
        $languageScript = <<<HTML
                <script>window.__trans = $translations</script>
            HTML;

    } catch (\Exception $e) {
       
        $exceptionMessage = $e->getMessage();
        $languageScript = <<<HTML
            <script>console.error("$exceptionMessage")</script>
        HTML;
        
    }

    return new HtmlString(<<<HTML
        $languageScript
    HTML);
}
