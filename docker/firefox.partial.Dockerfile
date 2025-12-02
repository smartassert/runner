 RUN install -d -m 0755 /etc/apt/keyrings \
    && apt-get update \
    && apt-get install wget \
    && wget -q https://packages.mozilla.org/apt/repo-signing-key.gpg -O- | tee /etc/apt/keyrings/packages.mozilla.org.asc > /dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/packages.mozilla.org.asc] https://packages.mozilla.org/apt mozilla main" | tee -a /etc/apt/sources.list.d/mozilla.list > /dev/null \
    && echo 'Package: *' >> /etc/apt/preferences.d/mozilla \
    && echo 'Pin: origin packages.mozilla.org' >> /etc/apt/preferences.d/mozilla \
    && echo 'Pin-Priority: 1000' >> /etc/apt/preferences.d/mozilla \
    && apt-get update \
    && apt-get install firefox --assume-yes --no-install-recommends \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
