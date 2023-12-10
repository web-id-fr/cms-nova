import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-field-item-field', IndexField)
  app.component('detail-field-item-field', DetailField)
  app.component('form-field-item-field', FormField)
})
