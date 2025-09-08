<?php
// Componentes shadcn/ui para o projeto
function shadcn_button($text, $variant = 'default', $size = 'default', $additional_classes = '', $href = null, $onclick = null) {
    $base_classes = "inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none ring-offset-background";
    
    $variant_classes = [
        'default' => "bg-primary text-primary-foreground hover:bg-primary/90",
        'destructive' => "bg-destructive text-destructive-foreground hover:bg-destructive/90",
        'outline' => "border border-input hover:bg-accent hover:text-accent-foreground",
        'secondary' => "bg-secondary text-secondary-foreground hover:bg-secondary/80",
        'ghost' => "hover:bg-accent hover:text-accent-foreground",
        'link' => "underline-offset-4 hover:underline text-primary"
    ];
    
    $size_classes = [
        'default' => "h-10 py-2 px-4",
        'sm' => "h-9 px-3 rounded-md",
        'lg' => "h-11 px-8 rounded-md",
        'icon' => "h-10 w-10"
    ];
    
    $classes = $base_classes . " " . ($variant_classes[$variant] ?? $variant_classes['default']) . " " . ($size_classes[$size] ?? $size_classes['default']) . " " . $additional_classes;
    
    if ($href) {
        return "<a href='$href' class='$classes'>$text</a>";
    } else {
        $onclick_attr = $onclick ? "onclick='$onclick'" : "";
        return "<button class='$classes' $onclick_attr>$text</button>";
    }
}

function shadcn_card($title, $content, $footer = null, $additional_classes = '') {
    $card = "<div class='rounded-lg border bg-card text-card-foreground shadow-sm $additional_classes'>";
    $card .= "<div class='p-6'>";
    if ($title) {
        $card .= "<h3 class='text-2xl font-semibold leading-none tracking-tight mb-4'>$title</h3>";
    }
    $card .= "<div class='text-sm text-muted-foreground mb-4'>$content</div>";
    if ($footer) {
        $card .= "<div class='pt-4 border-t'>$footer</div>";
    }
    $card .= "</div>";
    $card .= "</div>";
    return $card;
}

function shadcn_input($name, $label, $value = '', $type = 'text', $placeholder = '', $required = false) {
    $required_attr = $required ? 'required' : '';
    $input = "<div class='mb-4'>";
    $input .= "<label for='$name' class='block text-sm font-medium mb-2'>$label</label>";
    $input .= "<input type='$type' id='$name' name='$name' value='$value' placeholder='$placeholder' $required_attr class='flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50'>";
    $input .= "</div>";
    return $input;
}

function shadcn_alert($title, $description, $variant = 'default') {
    $variant_classes = [
        'default' => "bg-background text-foreground",
        'destructive' => "border-destructive/50 text-destructive dark:border-destructive [&>svg]:text-destructive"
    ];
    
    $alert = "<div class='rounded-md border p-4 mb-4 " . ($variant_classes[$variant] ?? $variant_classes['default']) . "'>";
    $alert .= "<div class='font-medium'>$title</div>";
    $alert .= "<div class='text-sm opacity-90'>$description</div>";
    $alert .= "</div>";
    return $alert;
}

function shadcn_badge($text, $variant = 'default') {
    $variant_classes = [
        'default' => "bg-primary text-primary-foreground hover:bg-primary/80",
        'secondary' => "bg-secondary text-secondary-foreground hover:bg-secondary/80",
        'destructive' => "bg-destructive text-destructive-foreground hover:bg-destructive/80",
        'outline' => "text-foreground"
    ];
    
    return "<div class='inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 " . ($variant_classes[$variant] ?? $variant_classes['default']) . "'>" . $text . "</div>";
}
?>