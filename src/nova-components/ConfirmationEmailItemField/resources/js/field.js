import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-confirmation-email-item-field', IndexField)
  app.component('detail-confirmation-email-item-field', DetailField)
  app.component('form-confirmation-email-item-field', FormField)
})
