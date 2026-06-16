import { computed } from 'vue';

export function useSectionStyles(props) {
  const sectionStyles = computed(() => {
    const styles = {};
    const s = props.section?.styles || {};
    
    // Background color
    if (s.backgroundColor) {
      styles.backgroundColor = s.backgroundColor;
    }
    
    // Background image
    if (s.backgroundImage) {
      styles.backgroundImage = `url(${s.backgroundImage})`;
      styles.backgroundPosition = s.backgroundPosition || 'center';
      styles.backgroundSize = s.backgroundSize || 'cover';
      styles.backgroundRepeat = s.backgroundRepeat || 'no-repeat';
    }
    
    // Gradient background (si existe)
    if (s.background && s.background.includes('gradient')) {
      styles.background = s.background;
    }
    
    // Box Shadow
    if (s.boxShadow && s.boxShadow !== 'none') {
      styles.boxShadow = s.boxShadow;
    }
    
    // Border
    if (s.borderWidth) {
      styles.borderWidth = `${s.borderWidth}px`;
      styles.borderStyle = s.borderStyle || 'solid';
      styles.borderColor = s.borderColor || '#e5e7eb';
    }
    
    if (s.borderRadius) {
      styles.borderRadius = `${s.borderRadius}px`;
    }
    
    return styles;
  });

  const containerPadding = computed(() => {
    const s = props.section?.styles || {};
    const classes = [];
    
    if (s.paddingTop !== undefined) {
      classes.push(`pt-[${s.paddingTop}px]`);
    }
    if (s.paddingBottom !== undefined) {
      classes.push(`pb-[${s.paddingBottom}px]`);
    }
    if (s.paddingLeft !== undefined) {
      classes.push(`pl-[${s.paddingLeft}px]`);
    }
    if (s.paddingRight !== undefined) {
      classes.push(`pr-[${s.paddingRight}px]`);
    }
    
    return classes;
  });

  const overlayOpacity = computed(() => {
    return props.section?.styles?.overlayOpacity || 0;
  });

  const contentStyles = computed(() => {
    const s = props.section?.styles || {};
    const styles = {};
    
    if (s.color) {
      styles.color = s.color;
    }
    if (s.textAlign) {
      styles.textAlign = s.textAlign;
    }
    
    return styles;
  });

  const className = computed(() => {
    return props.section?.styles?.className || '';
  });

  return {
    sectionStyles,
    containerPadding,
    overlayOpacity,
    contentStyles,
    className
  };
}
