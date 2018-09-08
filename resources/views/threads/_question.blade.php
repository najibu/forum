{{-- Editing the question --}}
<div class="panel panel-default" v-if="editing">
    <div class="panel-heading">
        <div class="level">
            <input type="text" value="{{ $thread->title }}" class="form-control">
        </div>
    </div>

    <div class="panel-body">
        <div class="form-group">
            <textarea name="body" class="form-control" rows="10">{{ $thread->body }}</textarea>
        </div>
    </div>

    <div class="panel-footer">
        <div class="level">
            <button class="btn btn-xs level-item" @click="editing = true" v-show="! editing">Edit</button>
            <button class="btn btn-primary btn-xs level-item" @click="">Update</button>
            <button class="btn btn-xs level-item" @click="editing = false">Cancle</button>

            @can ('update', $thread)
                <form action="{{ $thread->path() }}" method="POST" class="ml-a">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-link">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
</div>

{{-- Viewing the question --}}
<div class="panel panel-default" v-else>
    <div class="panel-heading">
        <div class="level">
            <img src="{{ $thread->creator->avatar_path }}"
            alt="{{ $thread->creator->name }}"
            width="25"
            height="25"
            class="mr-1">

            <span class="flex">
                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                {{ $thread->title }}
            </span>


        </div>
    </div>

    <div class="panel-body">
        {{ $thread->body }}
    </div>

    <div class="panel-footer">
        <button class="btn btn-xs" @click="editing = true">Edit</button>
    </div>
</div>
