import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-template-item-field', IndexField)
  app.component('detail-template-item-field', DetailField)
  app.component('form-template-item-field', FormField)
})
