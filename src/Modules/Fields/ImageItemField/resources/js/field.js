import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
    app.component('index-image-item-field', IndexField)
    app.component('detail-image-item-field', DetailField)
    app.component('form-image-item-field', FormField)
})
