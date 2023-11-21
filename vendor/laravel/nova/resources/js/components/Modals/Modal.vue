<template>
  <teleport to="body">
    <template v-if="show">
      <div
        v-bind="defaultAttributes"
        class="modal fixed inset-0 z-[60]"
        :class="{
          'px-3 md:px-0 py-3 md:py-6 overflow-x-hidden overflow-y-auto':
            modalStyle === 'window',
          'h-full': modalStyle === 'fullscreen',
        }"
        :role="role"
        :data-modal-open="show"
        :aria-modal="show"
      >
        <div
          class="@container/modal relative mx-auto z-20"
          :class="contentClasses"
          ref="modalContent"
        >
          <slot />
        </div>
      </div>

      <div
        class="fixed inset-0 z-[55] bg-gray-500 dark:bg-gray-900 opacity-75"
        dusk="modal-backdrop"
      />
    </template>
  </teleport>
</template>

<script setup>
import { useStore } from 'vuex'
import filter from 'lodash/filter'
import omit from 'lodash/omit'
import { useFocusTrap } from '@vueuse/integrations/useFocusTrap'
import { useEventListener } from '@vueuse/core'
import {
  computed,
  nextTick,
  onBeforeUnmount,
  onMounted,
  ref,
  useAttrs,
  watch,
} from 'vue'

const modalContent = ref(null)

const { activate, deactivate } = useFocusTrap(modalContent, {
  initialFocus: true,
  allowOutsideClick: false,
  escapeDeactivates: false,
})

const attrs = useAttrs()

const emit = defineEmits(['showing', 'closing', 'close-via-escape'])

defineOptions({ inheritAttrs: false })

const props = defineProps({
  show: { type: Boolean, default: false },
  size: {
    type: String,
    default: 'xl',
    validator: v =>
      [
        'sm',
        'md',
        'lg',
        'xl',
        '2xl',
        '3xl',
        '4xl',
        '5xl',
        '6xl',
        '7xl',
      ].includes(v),
  },
  modalStyle: { type: String, default: 'window' },
  role: { type: String, default: 'dialog' },
  useFocusTrap: { type: Boolean, default: false },
})

watch(
  () => props.show,
  v => handleVisibilityChange(v)
)

useEventListener(document, 'keydown', e => {
  if (e.key === 'Escape' && props.show === true) {
    emit('close-via-escape', e)
  }
})

onMounted(() => {
  if (props.show === true) handleVisibilityChange(true)
})

onBeforeUnmount(() => {
  document.body.classList.remove('overflow-hidden')
  Nova.resumeShortcuts()
  if (props.useFocusTrap === true) deactivate()
})

const store = useStore()

async function handleVisibilityChange(showing) {
  await nextTick()

  if (showing === true) {
    emit('showing')
    document.body.classList.add('overflow-hidden')
    Nova.pauseShortcuts()
    if (props.useFocusTrap === true) activate()
  } else {
    emit('closing')
    document.body.classList.remove('overflow-hidden')
    Nova.resumeShortcuts()
  }

  store.commit('allowLeavingModal')
}

const defaultAttributes = computed(() => {
  return omit(attrs, ['class'])
})

const sizeClasses = computed(() => {
  return {
    sm: 'max-w-sm',
    md: 'max-w-md',
    lg: 'max-w-lg',
    xl: 'max-w-xl',
    '2xl': 'max-w-2xl',
    '3xl': 'max-w-3xl',
    '4xl': 'max-w-4xl',
    '5xl': 'max-w-5xl',
    '6xl': 'max-w-6xl',
    '7xl': 'max-w-7xl',
  }
})

const contentClasses = computed(() => {
  let windowClasses = props.modalStyle === 'window' ? sizeClasses.value : {}

  return filter([
    windowClasses[props.size] ?? null,
    props.modalStyle === 'fullscreen' ? 'h-full' : '',
    attrs.class,
  ])
})
</script>
