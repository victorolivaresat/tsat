<template>
  <button type="button" @click="show = true">
    <slot />
    <teleport v-if="show" to="#dropdown">
      <div>
        <div class="fixed top-0 right-0 left-0 bottom-0 z-40 bg-black opacity-20"  @click="show = false" />
        <div ref="dropdown" class="absolute z-50" @click.stop="show = !autoClose">
          <slot name="dropdown" />
        </div>
      </div>
    </teleport>
  </button>
</template>

<script>
import { createPopper } from '@popperjs/core'

export default {
  props: {
    placement: {
      type: String,
      default: 'bottom-end',
    },
    autoClose: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      show: false,
    }
  },
  watch: {
    show(show) {
      if (show) {
        this.$nextTick(() => {
          this.popper = createPopper(this.$el, this.$refs.dropdown, {
            placement: this.placement,
            modifiers: [
              {
                name: 'preventOverflow',
                options: {
                  altBoundary: true,
                },
              },
            ],
          })
        })
      } else if (this.popper) {
        setTimeout(() => this.popper.destroy(), 100)
      }
    },
  },
  mounted() {
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        this.show = false
      }
    })
  },
}
</script>
