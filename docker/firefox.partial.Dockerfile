RUN echo 'deb http://deb.debian.org/debian/ unstable main contrib non-free' >> /etc/apt/sources.list \
    && echo 'Package: *' >> /etc/apt/preferences.d/99pin-unstable \
    && echo 'Pin: release a=stable' >> /etc/apt/preferences.d/99pin-unstable \
    && echo 'Pin-Priority: 900' >> /etc/apt/preferences.d/99pin-unstable \
    && echo 'Package: *' >> /etc/apt/preferences.d/99pin-unstable \
    && echo 'Pin release a=unstable' >> /etc/apt/preferences.d/99pin-unstable \
    && echo 'Pin-Priority: 10' >> /etc/apt/preferences.d/99pin-unstable \
    && apt-get update \
    && apt-get install -y --no-install-recommends -t unstable firefox \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
