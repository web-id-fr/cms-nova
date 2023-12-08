import IndexField from './components/IndexField'
import DetailField from './components/DetailField'

Nova.booting((app, store) => {
  app.component('index-page-url-item-field', IndexField)
  app.component('detail-page-url-item-field', DetailField)
})
