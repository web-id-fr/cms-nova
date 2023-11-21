import LanguageSwitcher from "./components/LanguageSwitcher";
import {createApp,defineComponent} from 'vue';

Nova.booting((app, store) => {
    window.addEventListener('DOMContentLoaded',()=>{
        let appHeader = document.getElementsByTagName('header');

        if (appHeader.length > 0) {
            let languages = Nova.config('language_switcher').languages;
            let switchLang = defineComponent({
                extends: LanguageSwitcher, data() {
                    return {
                        langs: languages,
                    }
                }
            })

            let lang =  document.createElement('div');
            lang.className = 'mr-3';
            let newApp = createApp(switchLang);
            newApp.component('Icon', app._context.components.HeroiconsOutlineGlobe);
            newApp.mount(lang);
            appHeader[0].lastChild.lastChild.insertBefore(lang,appHeader[0].lastChild.lastChild.firstChild);
        }
    })
})
