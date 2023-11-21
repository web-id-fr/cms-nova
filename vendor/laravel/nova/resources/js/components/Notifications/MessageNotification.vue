<template>
  <div
    class="bg-white dark:bg-gray-800 flex items-start py-4 px-4 space-x-4"
    :dusk="`notification-${notification.id}`"
  >
    <div class="shrink-0">
      <Icon :type="icon" :class="notification.iconClass" />
    </div>

    <div class="flex-auto space-y-4">
      <div>
        <div class="flex items-center">
          <div class="flex-auto">
            <p
              class="mr-1 text-gray-600 dark:text-gray-400 leading-normal break-words"
            >
              {{ notification.message }}
            </p>
          </div>
        </div>

        <p class="mt-1 text-xs" :title="notification.created_at">
          {{ notification.created_at_friendly }}
        </p>
      </div>

      <Button
        v-if="hasUrl"
        @click="handleClick"
        :label="notification.actionText"
        size="small"
      />

      <div class="flex items-start -ml-3">
        <Button
          @click.stop="handleDeleteClick"
          dusk="delete-button"
          variant="ghost"
          size="small"
          leading-icon="trash"
          :label="__('Delete')"
        />

        <Button
          @click.stop="$emit('mark-as-read')"
          dusk="mark-as-read-button"
          variant="ghost"
          size="small"
          leading-icon="eye"
          :label="__('Mark Read')"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { mapMutations } from 'vuex'
import { Button } from 'laravel-nova-ui'

export default {
  components: {
    Button,
  },

  name: 'MessageNotification',

  props: {
    notification: {
      type: Object,
      required: true,
    },
  },

  methods: {
    ...mapMutations(['toggleNotifications']),

    handleClick() {
      this.toggleNotifications()
      this.visit()
      this.$emit('hide')
    },

    handleDeleteClick() {
      if (
        confirm(this.__('Are you sure you want to delete this notification?'))
      ) {
        this.$emit('delete-notification')
      }
    },

    visit() {
      if (this.hasUrl) {
        return Nova.visit(this.notification.actionUrl, {
          openInNewTab: this.notification.openInNewTab || false,
        })
      }
    },
  },

  computed: {
    icon() {
      return this.notification.icon
    },

    hasUrl() {
      return this.notification.actionUrl
    },
  },
}
</script>
