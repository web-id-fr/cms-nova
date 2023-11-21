import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-recipient-item-field', IndexField)
  app.component('detail-recipient-item-field', DetailField)
  app.component('form-recipient-item-field', FormField)
})
