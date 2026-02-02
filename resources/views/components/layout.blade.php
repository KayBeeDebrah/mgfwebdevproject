
<!--Pros are Default values in case specifics are not indicated-->
@props(['title' => 'Laravel'])

<!DOCTYPE html>
<html lang="en" data-theme="nord">
<!--Our master page-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$title}}</title>
       <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">-->
       <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
       <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> 
       <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />  
    </head>
    <body>
 
<!--Slot = contentplace holder-->
    <main class="max-w-3xl mx-auto">
       {{$slot}}
    </main>
    </body>
</html>
