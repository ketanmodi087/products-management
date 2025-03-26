<template>
    <div class="skeleton-container">
        <!-- Table Header Skeleton -->
        <div class="table-header">
            <div class="skeleton-row">
                <div class="skeleton-cell header-cell"></div>
                <div class="skeleton-cell header-cell"></div>
                <div class="skeleton-cell header-cell"></div>
                <div class="skeleton-cell header-cell"></div>
                <div class="skeleton-cell header-cell"></div>
                <div class="skeleton-cell header-cell"></div>
            </div>
        </div>

        <!-- Table Body Skeleton -->
        <div class="table-body">
            <div v-for="n in 10" :key="n" class="skeleton-row">
                <div class="skeleton-cell"></div>
                <div class="skeleton-cell"></div>
                <div class="skeleton-cell">
                    <div class="skeleton-badge"></div>
                </div>
                <div class="skeleton-cell"></div>
                <div class="skeleton-cell"></div>
                <div class="skeleton-cell">
                    <div class="skeleton-actions">
                        <div class="skeleton-action-btn"></div>
                        <div class="skeleton-action-btn"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ProductSkeleton'
}
</script>

<style lang="scss" scoped>
@use '../assets/common-styles' as *;
@use "sass:color";

.skeleton-container {
    background: $white;
    border-radius: $radius-lg;
    overflow: hidden;
    box-shadow: $shadow-sm;
    width: 100%;
    min-width: 900px;
}

.table-header {
    background-color: $background-light;
    padding: $spacing-md;
}

.skeleton-row {
    display: grid;
    grid-template-columns: 60px 2fr 1fr 1.5fr 1.5fr 100px;
    gap: $spacing-md;
    padding: $spacing-md;
    border-bottom: 1px solid $border-color;
    min-height: 48px;
}

.skeleton-cell {
    height: 32px;
    background-color: $background-light;
    border-radius: $radius-sm;
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.header-cell {
    height: 24px;
    background-color: color.adjust($background-light, $lightness: -5%);
}

.skeleton-badge {
    width: 70px;
    height: 28px;
    background-color: $background-light;
    border-radius: $radius-full;
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.skeleton-actions {
    display: flex;
    gap: $spacing-sm;
    height: 32px;
}

.skeleton-action-btn {
    width: 28px;
    height: 28px;
    background-color: $background-light;
    border-radius: $radius-full;
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .5;
    }
}
</style>