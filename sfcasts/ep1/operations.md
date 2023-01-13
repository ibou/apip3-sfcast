# Operations / Endpoints

API platform works by taking a class like Dragon Treasure and telling API platform
that you want to expose this as a resource in your api. And you do that by adding
this API resource attribute. Right now we're putting this above a doctrine entity
though In a future tutorial we'll learn that you can really put this API resource
above any class. Now to help the user fetch and create and edit that the data for
this resource, every resource has a set of operations and you can actually see these
in the profiler. So this is the profiler for our /api /dragon treasures json. And if
you click on API platform, as I mentioned on top, it tells you all the metadata for
this API resource. And down below it tells you the operations. This is a little bit
verbose here, but you can see we have a GI operation, a get collection operation, a
post-operation, a put operation, a patch operation, and finally a banana operation
getting delete. And you can also see these in over here in swagger. And each of these
has some subtle differences. For example, all of these will return data except for
the delete operation. They will also, out of those that return data, they post get
put in. Patch will return a single resource while Git will return a collection of
resources.

And some of these endpoints post put and patch expect us to send data while other
endpoints like delete Git and Git collection don't. By the way, if you're wondering
what, so most of these are pretty self-explanatory. This is going to get a
collection. This gets a single item post is to create delete this to delete. The only
kind of confusing one is put versus patch. You can see this says replaces the dragon
treasure and this updates the dragon treasure. The topic of put versus patch in APIs
is a hot topic, but an API platform put and patch work the same. They're both used to
update a resource and you'll see how they work as we go along. So one of the things
that you might want to do at the API platform is customize or remove some of these
operations or even add extra operations. So how do we do that? Well, if you want to,
as soon as you want to customize any of these operations, you need to actually put
them all, you need to add them into your API resource. And as we saw on our profile,
each of these is actually backed by a class.

So over in a class what we can do is after description, I'll add an oper, I'll add an
operations key out, an operations key. Notice I'm getting auto completion here cause
these are named arguments to the constructor of that class. I'll show you that in a
second. Set this to and array. And I'm literally just going to repeat all of those
end points. So get get tab and complete that. Get collection new post new, put new
patch, new delete. Now if I go over to our swagger documentation and refresh now
absolutely nothing changes. What I've just done is repeated exactly what the default
configuration already is. But now if we wanted to, let's say we don't want to allow
Dragon Treasures to be deleted, I can just remove that, delete, I'll even remove the
use statement. And now when we go over and refresh, delete is gone. That's no longer
possible to do that. All right, speaking of the configuration under API resource, as
I mentioned, the attributes are always classes. So I'm going to hold, hold commander
control to and click on AK resource to open it. This is really cool. Every single
argument to the constructor here is an option that we can pass to it. And almost all
of these have documentation above them that that give you a link to the documentation
where you can read more about these. Now we're going to talk about the most important
options, but this is a great resource to know about.

So for example, one argument here is called short name. If you look over in our API
right now, our model is known as Dragon Treasure, which obviously matches our class
name. But if you want you can change that. But before we do notice also that our URLs
are /API /dragon_treasures. And that's generated by taking the class, the name here,
and then just making it plural. So let's say that we just want this model to be known
as Treasure. So I'm going to go here and pass short name option set two treasure.

And as soon as we do that, watch this name here and watch the URLs. Nice. So it's now
known as Treasure as the short name everywhere. It's going to be referred to as
treasure and now it automatically generates the URL based off of that name, which is
kind of cool. But that's not the though. That's not the only way to configure the you
url. So in addition to, so the API resource is obvious a class, but all of these
operations are classes as well. So they follow the same rule. So I'm hold commander
control and click to open up the get class. And once again, all of these structor
arguments are options. They can pass to it and most of 'em have documentation above
there. So one really important here is called U R I template. So we can control what
the u I looks on an operation by operation basis if we want to. So check this out.
Remember GIT is how you get a single resource. So I'm going to pay say u i template,
set two /dragon plunder /curly brace id what whether you so pass whatever the ID is
of this. And then forget collection. Let's also pass the UI template there, which
will just be /dragon plunder.

Now over here, refresh. Beautiful the other operations, keep the old U url, the new
ones have the new U URLs. And later when we talk about sub resources, we'll talk a
little bit more about U R I template and also a related option called u i variables.
But with just knowing this, you now can control the URLs. Of course, it's a bit silly
to have two operations with a different url. So I'm going to go back and um, undo
those. All right, now that we know a bunch about the API resource and these
operations, let's talk about the next, let's talk about the heart of API platform,
which is Symfony's. Serializer. That's the service whose job is to transform any
object like dragon treasure into J S O. We've been seeing.