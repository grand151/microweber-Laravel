<?php

namespace Tests\Browser\Components;

use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;
use MicroweberPackages\Multilanguage\MultilanguageHelpers;
use PHPUnit\Framework\Assert as PHPUnit;

class AdminContentMultilanguage extends BaseComponent
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return '#mw-admin-container';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param Browser $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        // $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [];
    }

    public function addLanguage(Browser $browser, $locale)
    {


        $mustAddNewLang = true;
        $goToMultilanguagePage = true;
        $mustActivateMultilanguage = false;

//        if ($browser->driver->getCurrentURL() == route('admin.multilanguage.index')) {
//            $goToMultilanguagePage = false;
//        }
//

        $goToMultilanguagePage = true;



        if (is_lang_supported($locale)) {
          //  $mustAddNewLang = false;
        }

        if(!MultilanguageHelpers::multilanguageIsEnabled()){
            $mustActivateMultilanguage = true;
        }


      if (!$browser->element('#is_active_quick[checked]')) {
            $mustActivateMultilanguage = true;
//
//            $output = $browser->script("
//            var moduleElement = $('input[id=is_active_quick][checked]');
//            if (moduleElement.length > 0) {
//              return true;
//            }
//            return false;
//            ");
//
//           if ($output[0]) {
//               $mustActivateMultilanguage = false;
//           }
        }


        if ($goToMultilanguagePage) {
            $browser->visit(route('admin.multilanguage.index'));
        }

        if ($mustActivateMultilanguage) {

       //     $browser->waitForText('Multilanguage is active?', 20);
            // $browser->script('$(".module-switch-active-form .custom-control-label").click();');
          //  $browser->click('.module-switch-active-form .custom-control-label');
            if (!$browser->attribute('#is_active_quick', 'checked')) {

                $browser->click('#is_active_quick');
                $browser->waitForReload();
            }

        }
        if (count($browser->driver->findElements(WebDriverBy::cssSelector('.js-lang-tr-'.$locale))) > 0) {
             // already have language
            return;
        }


        $browser->pause(1000);
        if ($mustAddNewLang) {
            //$browser->waitForText('Add new language', 20);
            $browser->select('.js-dropdown-text-language', $locale);
            $browser->pause(3000);
            $browser->click('.js-add-language');
            //$browser->pause(8000);
            $browser->waitFor('.js-lang-tr-'.$locale, 120);
            $browser->waitForText($locale, 30);
        }

    }

    public function fillTitle(Browser $browser, $title, $locale)
    {
        $browser->within(new AdminMultilanguageFields, function ($browser) use ($title, $locale) {
            $browser->fillInput('title', $title, $locale);
        });
    }

    public function fillUrl(Browser $browser, $url, $locale)
    {
        $browser->within(new AdminMultilanguageFields, function ($browser) use ($url, $locale) {
            $browser->fillInput('url', $url, $locale);
        });
    }

    public function fillContent(Browser $browser, $content, $locale)
    {
        $browser->within(new AdminMultilanguageFields, function ($browser) use ($content, $locale) {
            $browser->fillMwEditor('content', $content, $locale);
        });
    }

    public function fillContentBody(Browser $browser, $contentBody, $locale)
    {
        $browser->within(new AdminMultilanguageFields, function ($browser) use ($contentBody, $locale) {
            $browser->fillMwEditor('content_body', $contentBody, $locale);
        });
    }

    /**
     * SEO META
     */
    public function fillContentMetaTitle(Browser $browser, $title, $locale)
    {


        $browser->pause(1000);
        $browser->script("document.querySelector('.js-seo-card-tab').scrollIntoView({block: 'end', inline: 'nearest',behavior :'auto'});");
        $browser->pause(1000);

        if (!$browser->driver->findElement(WebDriverBy::cssSelector('#seo-settings'))->isDisplayed()) {
            $browser->pause(1000);
            $browser->click('.js-seo-card-tab');
        }

        $browser->within(new AdminMultilanguageFields, function ($browser) use ($title, $locale) {
            $browser->script("document.querySelector('[name=\"content_meta_title\"]').scrollIntoView({block: 'nearest', inline: 'nearest',behavior :'auto'});");
            $browser->fillInput('content_meta_title', $title, $locale);
        });
    }

    public function fillContentMetaKeywords(Browser $browser, $keywords, $locale)
    {
        $browser->scrollTo('.js-card-search-engine');
        if (!$browser->driver->findElement(WebDriverBy::cssSelector('#seo-settings'))->isDisplayed()) {
            //  $browser->script('$(".js-card-search-engine a.btn").click();');
            $browser->click('.js-seo-card-tab');

            $browser->pause(1000);
        }

        $browser->within(new AdminMultilanguageFields, function ($browser) use ($keywords, $locale) {
            $browser->fillInput('content_meta_keywords', $keywords, $locale);
        });
    }

    public function fillDescription(Browser $browser, $description, $locale)
    {
        $browser->scrollTo('.js-card-search-engine');
        if (!$browser->driver->findElement(WebDriverBy::cssSelector('#seo-settings'))->isDisplayed()) {
            //$browser->script('$(".js-card-search-engine a.btn").click();');
            $browser->click('.js-seo-card-tab');
            $browser->pause(1000);
        }

        $browser->within(new AdminMultilanguageFields, function ($browser) use ($description, $locale) {
            $browser->fillTextarea('description', $description, $locale);
        });
    }
}
